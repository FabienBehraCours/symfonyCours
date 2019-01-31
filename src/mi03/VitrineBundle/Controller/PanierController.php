<?php
/**
 * Created by PhpStorm.
 * User: fabien
 * Date: 03/12/18
 * Time: 14:39
 */

namespace mi03\VitrineBundle\Controller;

use mi03\VitrineBundle\Entity\Commande;
use mi03\VitrineBundle\Entity\LigneCommande;
use mi03\VitrineBundle\Entity\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{

    public function indexAction(){
        $session = $this->get("session");
        $panier = $session->get('panier',new Panier());

        //création de la commande
        $commande = $this->callServiceSeeContentPanier($panier);
        $prixPanier = $this->callServiceMontantPanier($panier);

        return $this->render(
            'mi03VitrineBundle:Default/PanierView:panier.html.twig',
            array('ligneCommande' => $commande->getLigneCommande(), 'prixPanier' => $prixPanier));
    }

    public function callServiceSeeContentPanier($panier){
        $command = new Commande();
        $servicePanierToCommande = $this->container->get('mi03_vitrine.panierToCommande');
        if($panier!= null && count($panier->getContenu())>0){
            $command = $servicePanierToCommande->seeContentPanier($panier);
        }
        return $command;
    }

    public function callServiceCommandToPanier($panier, $idClient){
        $command = null;
        $servicePanierToCommande = $this->container->get('mi03_vitrine.panierToCommande');
        if($panier!= null && count($panier->getContenu())>0){
            $command = $servicePanierToCommande->convertPanierToCommande($panier, $idClient);
        }
        return $command;
    }

    public function callServiceMontantPanier($panier){
        $serviceMontantPanier = $this->container->get('mi03_vitrine.panierToCommande');
        $sum = 0;
        if($panier!= null && count($panier->getContenu())>0){
            $sum = $serviceMontantPanier->getPricePanier($panier);
        }
        return $sum;
    }

    public function callServiceRemoveQuantityInStockArticle($commande){
        $serviceRemoveQuantityInStockArticle = $this->container->get('mi03_vitrine.panierToCommande');
        if($commande!= null){
            $serviceRemoveQuantityInStockArticle->removeQuantityInStockArticle($commande);
        }
    }

    public function getServiceMailerUtils(){
        return $this->container->get('miO3_vitrine.mailerUtils');
    }


    public function viderPanierAction(){
        $session = $this->get("session");
        $session->set('panier',new Panier());
        $session->set('prixPanier',0);


        return $this->redirectToRoute("mi03_vitrine_panier");
    }

    public function validerPanierAction(){
        $session = $this->get("session");
        $panier = $session->get('panier',new Panier());
        $user = $this->getUser();
        if($user != null){
            $clientId = $user->getId();
        }

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('mi03_vitrine_login');
        }else{
            //création de la commande
            $commande = $this->callServiceCommandToPanier($panier, $clientId);
            $prixPanier = $this->callServiceMontantPanier($panier);

            if($commande!= null){
                $this->callServiceRemoveQuantityInStockArticle($commande);
                $session->set('panier', new Panier());
                $this->getServiceMailerUtils()->sendMailConfirmationCommande($commande, $commande->getClient());
                return $this->render('@mi03Vitrine/Default/CommandeView/recapCommande.html.twig', array('commande' => $commande));
            }else{
                return $this->render('mi03VitrineBundle:Default/ErrorsView:connect.html.twig');
            }
        }
    }

    public function deleteArticlePanierAction($idArticle){
        $session = $this->get("session");
        $panier = $session->get('panier',new Panier());
        $array = $panier->getContenu();
        $idArticle=intval($idArticle,10);

        if(array_key_exists($idArticle,$array)){
            unset($array[$idArticle]);
        }

        $panier->setContenu($array);
        $session->set('panier',$panier);
        return $this->indexAction();
    }

    public function changeQuantityArticlePanierAction($idArticle, Request $request){
        $session = $this->get("session");
        $panier = $session->get('panier',new Panier());
        $array = $panier->getContenu();
        $idArticle=intval($idArticle,10);

        $quantity = $request->request->get('quantity');
        if($quantity > 0){
            if(array_key_exists($idArticle,$array)){
                $array[$idArticle]=$quantity;
            }
        }else{
            return $this->deleteArticlePanierAction($idArticle);
        }

        $panier->setContenu($array);
        $session->set('panier',$panier);
        return $this->indexAction();
    }

    public function sendMailConfirmationCommande($commande){
//        $transport = (new Swift_SmtpTransport('smtp.example.org', 25))
//            ->setUsername('your username')
//            ->setPassword('your password')
//        ;
//
//        $mailer = new \Swift_Mailer($transport);
        $message = (new \Swift_Message('Vitrine : Confirmation commande'))
        ->setFrom('communication@vitrine.com')
        ->setTo($commande->getClient()->getMail())
        ->setBody(
            $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                '@mi03Vitrine/Default/Emails/confirmationCommande.html.twig',
                array('commande' => $commande, 'name' => $commande->getClient()->getNomComplet())
            ),
            'text/html'
        );

//    $mailer->send($message);
    }


}
