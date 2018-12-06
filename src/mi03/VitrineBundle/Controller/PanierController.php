<?php
/**
 * Created by PhpStorm.
 * User: fabien
 * Date: 03/12/18
 * Time: 14:39
 */

namespace mi03\VitrineBundle\Controller;

use mi03\VitrineBundle\Entity\Commande;
use mi03\VitrineBundle\Entity\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{

    public function indexAction(){
        $session = $this->get("session");
        $panier = $session->get('panier',new Panier());

        //création de la commande
        $commande = $this->callServicePanierToCommande($panier);
        $prixPanier = $this->callServiceMontantPanier($panier);

        return $this->render(
            'mi03VitrineBundle:Default:panier.html.twig',
            array('ligneCommande' => $commande->getLigneCommande(), 'prixPanier' => $prixPanier));
    }

    public function callServicePanierToCommande($panier){
        $command = new Commande();
        $servicePanierToCommande = $this->container->get('mi03_vitrine.panierToCommande');
        if($panier!= null && count($panier->getContenu())>0){
            $command = $servicePanierToCommande->convertPanierToCommande($panier);
        }
        return $command;
    }

    public function callServiceMontantPanier($panier){
        $serviceMontantPanier = $this->container->get('mi03_vitrine_montantPanier');
        $sum = 0;
        if($panier!= null && count($panier->getContenu())>0){
            $sum = $serviceMontantPanier->getPricePanier($panier);
        }
        return $sum;
    }


    public function viderPanierAction(){
        $session = $this->get("session");
        $session->set('panier',new Panier());
        $session->set('prixPanier',0);


        return $this->redirectToRoute("mi03_vitrine_panier");
    }


}
