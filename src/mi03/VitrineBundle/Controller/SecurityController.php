<?php
/**
 * Created by PhpStorm.
 * User: fabien
 * Date: 18/12/18
 * Time: 14:14
 */

namespace mi03\VitrineBundle\Controller;


use mi03\VitrineBundle\Entity\Client;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    public function loginAction(Request $request){


        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('mi03VitrineBundle:Default/Security:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error
        ));

    }

    public function logoutAction(Request $request){
        $this->get('session')->clear();
    }

    public function createAction(Request $request){

        $entity = new Client();
        $form = $this->createFormBuilder($entity,array(
            'validation_groups' => array('registration')
            ))
            ->add('nom', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('prenom', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('mail', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('save', SubmitType::class)
            ->getForm();
        //$form = $this->createForm(ClientType::class, $entity);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (count($em->getRepository('mi03VitrineBundle:Client')->findBy(array('mail' => $entity->getMail()))) == 0) {
                $encoder = $this->container->get('security.password_encoder');
                $encoded = $encoder->encodePassword($entity, $entity->getPassword());
                $entity->setPassword($encoded);
                $em->persist($entity);
                $em->flush();
                return $this->loginAction($request);
            }

            return $this->render('@mi03Vitrine/Default/Security/register.html.twig',
                array('form' => $form->createView(),
                    'error' => "Cet email n'est pas disponible"));
        }

        return $this->render('@mi03Vitrine/Default/Security/register.html.twig',
            array('form' => $form->createView(),
                'error' => null));
    }
}