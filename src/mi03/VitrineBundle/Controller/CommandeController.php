<?php

namespace mi03\VitrineBundle\Controller;

use mi03\VitrineBundle\Entity\Commande;
use mi03\VitrineBundle\Entity\LigneCommande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{
    /**
     * Lists all commande entities.
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
            $commandes = $em->getRepository('mi03VitrineBundle:Commande')->findAll();
        }elseif($this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            $commandes = $em->getRepository('mi03VitrineBundle:Commande')->findBy(array('client' => $user));
        }

        return $this->render('commande/index.html.twig', array(
            'commandes' => $commandes
        ));
    }



    /**
     * Creates a new commande entity.
     *
     */
    public function newAction(Request $request)
    {

        if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            throw $this->createAccessDeniedException();
        }

        $commande = new Commande();
        $form = $this->createForm('mi03\VitrineBundle\Form\CommandeType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('commande_show', array('id' => $commande->getId()));
        }

        return $this->render('commande/new.html.twig', array(
            'commande' => $commande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commande entity.
     *
     */
    public function showAction(Commande $commande)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            throw $this->createAccessDeniedException();
        }

        if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            //acces denied si on regarde une autre commande que les notres
            if($this->getUser()->getId() != $commande->getClient()->getId()){
                throw $this->createAccessDeniedException();
            }
        }


        $deleteForm = $this->createDeleteForm($commande);

        return $this->render('commande/show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     */
    public function editAction(Request $request, Commande $commande)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            throw $this->createAccessDeniedException();
        }


        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('mi03\VitrineBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commande entity.
     *
     */
    public function deleteAction(Request $request, Commande $commande)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            throw $this->createAccessDeniedException();
        }

        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush();
        }

        return $this->redirectToRoute('commande_index');
    }

    /**
     * Creates a form to delete a commande entity.
     *
     * @param Commande $commande The commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commande $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
