<?php

namespace PublicationBundle\Controller;

use PublicationBundle\Entity\Commentaire;
use PublicationBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commentaire controller.
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
        $em = $this -> getDoctrine() -> getManager();

        $commentaires = $em -> getRepository('PublicationBundle:Commentaire') -> findAll();

        return $this -> render('commentaire/index.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    /**
     * Creates a new commentaire entity.
     *
     */
    public function newAction(Request $request, $id)
    {
        $commentaire = new Commentaire();
        $form        = $this -> createForm('PublicationBundle\Form\CommentaireType', $commentaire);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            $publication = $this -> getDoctrine() -> getManager() -> getRepository(Publication::class) -> find($id);
            $commentaire -> setPublication($publication);
            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($commentaire);
            $em -> flush();

            return $this -> redirectToRoute('publication_show', [ 'id' => $id ]);
        }

        return $this -> render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form'        => $form -> createView(),
        ]);
    }

    /**
     * Finds and displays a commentaire entity.
     *
     */
    public function showAction(Commentaire $commentaire)
    {
        $deleteForm = $this -> createDeleteForm($commentaire);

        return $this -> render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
            'delete_form' => $deleteForm -> createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing commentaire entity.
     *
     */
    public function editAction(Request $request, Commentaire $commentaire)
    {
        $deleteForm = $this -> createDeleteForm($commentaire);
        $editForm   = $this -> createForm('PublicationBundle\Form\CommentaireType', $commentaire);
        $editForm -> handleRequest($request);

        if ($editForm -> isSubmitted() && $editForm -> isValid()) {
            $this -> getDoctrine() -> getManager() -> flush();

            return $this -> redirectToRoute('commentaire_edit', [ 'id' => $commentaire -> getId() ]);
        }

        return $this -> render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'edit_form'   => $editForm -> createView(),
            'delete_form' => $deleteForm -> createView(),
        ]);
    }

    /**
     * Deletes a commentaire entity.
     *
     */
    public function deleteAction(Request $request, Commentaire $commentaire)
    {
        $form = $this -> createDeleteForm($commentaire);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            $em = $this -> getDoctrine() -> getManager();
            $em -> remove($commentaire);
            $em -> flush();
        }

        return $this -> redirectToRoute('commentaire_index');
    }

    /**
     * Creates a form to delete a commentaire entity.
     *
     * @param Commentaire $commentaire The commentaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commentaire $commentaire)
    {
        return $this -> createFormBuilder()
            -> setAction($this -> generateUrl('commentaire_delete', [ 'id' => $commentaire -> getId() ]))
            -> setMethod('DELETE')
            -> getForm();
    }
}
