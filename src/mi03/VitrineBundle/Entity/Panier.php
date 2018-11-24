<?php
/**
 * Created by PhpStorm.
 * User: fbehr
 * Date: 23/11/2018
 * Time: 11:10
 */

namespace mi03\VitrineBundle\Entity;


class Panier
{
    private $contenu;
    //Tableau - contenu[i] = quantite d'article d’id=i dans le panier)
    public function __construct() {
        $this->contenu = [];
    }
    public function getContenu() {
        return $this->contenu;
    }
    public function ajoutArticle (Article $article, $qte = 1) {
        //si l'article est déjà dans une des lignes de commandes, on augmente juste sa quantité, sinon on créer une nouvelle ligne de commande
        /** @var LigneCommande $ligne */
        foreach($this->getDoctrine()->getManager()->getRepository(LigneCommande::class)->findAll() as $item => $ligne){
            if($ligne->getArticle()) // on regarde l'id
        }
        $commande = $this->getDoctrine()->getManager()->getRepository()->find(1);
        $ligneDeCommande = new LigneCommande($qte, $article->getPrice(), $article, $commande);
        array_push($this->contenu,$ligneDeCommande);
    }
    public function supprimeArticle($articleId) {
        // supprimer l'article $articleId du contenu
    }
    public function viderPanier() {
        $contenu = [];
    }
}