<?php

namespace mi03\VitrineBundle\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use mi03\VitrineBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Client controller.
 *
 */
class ClientController extends Controller
{
    /**
     * Lists all client entities.
     *
     */
    public function indexAction()
    {
        if(!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            throw $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $clients = $em->getRepository('mi03VitrineBundle:Client')->findAll();
        }elseif($this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            $clients = $em->getRepository('mi03VitrineBundle:Client')->findBy(array('id' => $user->getId()));
        }

        return $this->render('client/index.html.twig', array(
            'clients' => $clients,
        ));
    }

    /**
     * Creates a new client entity.
     *
     */
    public function newAction(Request $request)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            throw $this->createAccessDeniedException();
        }

        $client = new Client();
        $form = $this->createForm('mi03\VitrineBundle\Form\ClientType', $client, array(
            'validation_groups' => 'registration'));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            if(count($em->getRepository('mi03VitrineBundle:Client')->findBy(array('mail' => $client->getMail())))==0){
                $em->persist($client);
                $em->flush();
                return $this->redirectToRoute('client_show', array('id' => $client->getId()));
            }else{
                $form->get('mail')->addError(new FormError('Adresse mail déjà existante'));
                return $this->redirectToRoute('client_new');
            }
        }

        return $this->render('client/new.html.twig', array(
            'client' => $client,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a client entity.
     *
     */
    public function showAction(Client $client)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            throw $this->createAccessDeniedException();
        }

        if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            //acces denied si on regarde une autre commande que les notres
            if($this->getUser()->getId() != $client->getId()){
                throw $this->createAccessDeniedException();
            }
        }

        $deleteForm = $this->createDeleteForm($client);

        return $this->render('client/show.html.twig', array(
            'client' => $client,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing client entity.
     *
     */
    public function editAction(Request $request, Client $client)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            throw $this->createAccessDeniedException();
        }

        if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            //acces denied si on regarde une autre commande que les notres
            if($this->getUser()->getId() != $client->getId()){
                throw $this->createAccessDeniedException();
            }
        }

        $deleteForm = $this->createDeleteForm($client);
        $editForm = $this->createForm('mi03\VitrineBundle\Form\ClientType', $client);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_edit', array('id' => $client->getId()));
        }

        return $this->render('client/edit.html.twig', array(
            'client' => $client,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a client entity.
     *
     */
    public function deleteAction(Request $request, Client $client)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            throw $this->createAccessDeniedException();
        }

        $form = $this->createDeleteForm($client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($client);
            $em->flush();
        }

        return $this->redirectToRoute('client_index');
    }

    /**
     * Creates a form to delete a client entity.
     *
     * @param Client $client The client entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Client $client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $client->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
