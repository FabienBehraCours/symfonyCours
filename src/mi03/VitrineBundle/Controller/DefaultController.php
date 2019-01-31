<?php

namespace mi03\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $user = $this->getUser();
        dump($user);
        if($user != null){
            $name = $user->getNomComplet();
        }
        return $this->render(
            'mi03VitrineBundle:Default/IndexView:index.html.twig',
            array('name' => $name)
        );
    }

    public function indexBackOfficeAction(){
        //check si authentifié
        if(!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            throw $this->createAccessDeniedException();
        }

        //check si les bons rôles
        $this->denyAccessUnlessGranted('ROLE_ADMIN',null,'Unable to acces this page');

        return $this->render('@mi03Vitrine/Default/IndexView/indexBackOffice.html.twig');
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
