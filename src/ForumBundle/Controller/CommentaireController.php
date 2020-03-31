<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\CommentaireF;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * CommentaireF controller.
 *
 */
class CommentaireController extends Controller
{
    /**
     * Lists all commentaire entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentaires = $em->getRepository('ForumBundle:CommentaireF')->findAll();

        return $this->render('commentaire/index.html.twig', array(
            'commentaires' => $commentaires,
        ));
    }

    /**
     * Creates a new commentaire entity.
     *
     */
    public function newAction(Request $request)
    {
        $commentaire = new CommentaireF();
        $form = $this->createForm('ForumBundle\Form\CommentaireFType', $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('commentaire_show', array('id' => $commentaire->getId()));
        }

        return $this->render('commentaire/new.html.twig', array(
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commentaire entity.
     *
     */
    public function showAction(CommentaireF $commentaire)
    {
        $deleteForm = $this->createDeleteForm($commentaire);

        return $this->render('commentaire/show.html.twig', array(
            'commentaire' => $commentaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commentaire entity.
     *
     */
    public function editAction(Request $request, CommentaireF $commentaire)
    {
        $deleteForm = $this->createDeleteForm($commentaire);
        $editForm = $this->createForm('ForumBundle\Form\CommentaireFType', $commentaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commentaire_edit', array('id' => $commentaire->getId()));
        }

        return $this->render('commentaire/edit.html.twig', array(
            'commentaire' => $commentaire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commentaire entity.
     *
     */
    public function deleteAction(Request $request, CommentaireF $commentaire)
    {
        $form = $this->createDeleteForm($commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commentaire);
            $em->flush();
        }

        return $this->redirectToRoute('commentaire_index');
    }

    /**
     * Creates a form to delete a commentaire entity.
     *
     * @param CommentaireF $commentaire The commentaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CommentaireF $commentaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commentaire_delete', array('id' => $commentaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }




}
