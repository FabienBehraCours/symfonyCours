<?php
/**
 * Created by PhpStorm.
 * User: fabien
 * Date: 03/12/18
 * Time: 14:30
 */

namespace mi03\VitrineBundle\Controller;

use mi03\VitrineBundle\Entity\Article;
use mi03\VitrineBundle\Entity\Category;
use mi03\VitrineBundle\Entity\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CatalogueController extends Controller
{

    public function indexAction(){
        // on récupère les catégories de la bd
        $categories= $this->getDoctrine()->getManager()->getRepository("mi03VitrineBundle:Category")->findAll();
        return $this->render(
            'mi03VitrineBundle:Default:catalogue.html.twig',
            array('categories' => $categories));
    }

    public function articleParCategorieAction(Category $category){
        //le controller frontal voit qu'on attends une Category, il recoit l'id et cherche donc direct la cat crspdte
        $articlesByCategory = $category->getArticles();
        return $this->render(
            'mi03VitrineBundle:Default:articleParCategorie.html.twig',
            array('articlesParCategorie' => $articlesByCategory));
    }

    public function ajouterArticleAction(Article $article, Request $request){
        $session = $this->get("session");
        $panier = $session->get('panier', new Panier());

        $panier->ajoutArticle($article, 1);
        $session->set('panier',$panier);
        $session->set('prixPanier',$panier->getPrixPanier());

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
       // return $this->redirectToRoute("mi03_vitrine_articleParCategorie", array('id'=> $article->getCategory()->getId()));
    }
}