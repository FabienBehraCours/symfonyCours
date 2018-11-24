<?php

namespace mi03\VitrineBundle\Controller;

use mi03\VitrineBundle\Entity\Article;
use mi03\VitrineBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render(
            'mi03VitrineBundle:Default:index.html.twig',
            array('name' => $name)
        );

    }

    public function mentionsAction(){
        return $this->render(
            'mi03VitrineBundle:Default:mentions.html.twig'
        );
    }

    public function catalogueAction(){
        // on récupère les catégories de la bd
        $categories= $this->getDoctrine()->getManager()->getRepository(Category::class)->findAll();
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
}
