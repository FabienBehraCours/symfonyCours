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
    private $prixPanier;
    //Tableau - contenu[i] = quantite d'article d’id=i dans le panier)
    public function __construct() {
        $this->contenu = [];
        $prixPanier = 0.0;
    }
    public function getContenu() {
        return $this->contenu;
    }
    public function ajoutArticle (Article $article, $qte = 1) {
        //si l'article est déjà dans une des lignes de commandes, on augmente juste sa quantité, sinon on créer une nouvelle ligne de commande
        if($article == null){
            return false;
        }

       if(array_key_exists($article->getId(), $this->contenu)){
           $this->contenu[$article->getId()] += $qte;
       }else{
           $this->contenu[$article->getId()] = $qte;
       }
        $this->prixPanier += $article->getPrice()*$qte;


    }
    public function supprimeArticle($articleId) {
        // supprimer l'article $articleId du contenu
    }
    public function viderPanier() {
        $this->contenu = [];
    }

    public function getPrixPanier(){
        return $this->prixPanier;
    }

}