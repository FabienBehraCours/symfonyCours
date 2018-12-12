<?php
/**
 * Created by PhpStorm.
 * User: fabien
 * Date: 11/12/18
 * Time: 20:34
 */

namespace mi03\VitrineBundle\Controller;
use mi03\VitrineBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class GestionComptesController extends Controller
{


    public function connexionAction(Request $request){

        $client = new Client();

        $form = $this->createFormBuilder($client, array(
            'validation_groups' => array('login'),
            ))->add('mail', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('connect',SubmitType::class, array('attr'=> array('class'=> 'waves-effect waves-light btn')))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $serviceConnexion = $this->container->get('mi03_vitrine_gestionConnexion');
            if($serviceConnexion->checkConnexion($client)){
                $clientConnected = $serviceConnexion->connect($client);
                $session = $this->get('session');
                $session->set('clientId',$clientConnected->getId());
                return $this->redirectToRoute('mi03_vitrine_homepage', array('name' => $clientConnected->getNomComplet()));
            }else{
                //retunr une route d'echec de connexion
            }
        }

        return $this->render(
            'mi03VitrineBundle:Default/GestionComptesView:connexion.html.twig',
            array('form' => $form->createView()));
    }

    public function inscriptionAction(Request $request){

        $client = new Client();

        $form = $this->createFormBuilder($client, array(
            'validation_groups' => array('registration'),
        ))->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('mail', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('register',SubmitType::class, array('attr'=> array('class'=> 'waves-effect waves-light btn')))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $serviceRegistration = $this->container->get('mi03_vitrine_gestionInscription');
            if($serviceRegistration->checkConform($client)){
                $serviceRegistration->register($client);

                return $this->redirectToRoute('mi03_vitrine_homepage', array('name' => $client->getNomComplet()));
            }else{
                //return route error
            }
        }

        return $this->render(
            'mi03VitrineBundle:Default/GestionComptesView:inscription.html.twig',
            array('form' => $form->createView()));
    }
}