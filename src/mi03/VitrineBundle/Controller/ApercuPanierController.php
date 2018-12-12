<?php
/**
 * Created by PhpStorm.
 * User: fabien
 * Date: 07/12/18
 * Time: 09:52
 */

namespace mi03\VitrineBundle\Controller;


use mi03\VitrineBundle\Entity\Commande;
use mi03\VitrineBundle\Entity\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ApercuPanierController extends Controller
{
    public function indexAction(){
        $session = $this->get("session");
        $panier = $session->get('panier', new Panier());
        $command = new Commande();

        $command = $this->callServiceSeeContentPanier($panier);
        $prixPanier = $this->callServiceMontantPanier($panier);

        return $this->render(
            'mi03VitrineBundle:Default/PanierView:apercuPanier.html.twig',
            array('ligneCommande' => $command->getLigneCommande(), 'prixPanier' => $prixPanier));

    }

    public function callServiceSeeContentPanier($panier){
        $command = new Commande();
        $servicePanierToCommande = $this->container->get('mi03_vitrine.panierToCommande');
        if($panier!= null && count($panier->getContenu())>0){
            $command = $servicePanierToCommande->seeContentPanier($panier);
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
}