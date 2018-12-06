<?php

namespace mi03\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render(
            'mi03VitrineBundle:Default/IndexView:index.html.twig',
            array('name' => $name)
        );
    }

    public function mentionsAction(){
        return $this->render(
            'mi03VitrineBundle:Default:mentions.html.twig'
        );
    }

    public function clearSessionAction(){
        $this->get("session")->clear();
        return $this->redirectToRoute("mi03_vitrine_catalogue");
    }

}
