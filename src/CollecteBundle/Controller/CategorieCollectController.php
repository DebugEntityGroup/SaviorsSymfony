<?php

namespace CollecteBundle\Controller;

use CollecteBundle\Entity\CategorieCollect;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Categoriecollect controller.
 *
 */
class CategorieCollectController extends Controller
{
    /**
     * Lists all categorieCollect entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieCollects = $em->getRepository('CollecteBundle:CategorieCollect')->findAll();

        return $this->render('categoriecollect/index.html.twig', array(
            'categorieCollects' => $categorieCollects,
        ));
    }

    /**
     * Creates a new categorieCollect entity.
     *
     */
    public function newAction(Request $request)
    {
        $categorieCollect = new Categoriecollect();
        $form = $this->createForm('CollecteBundle\Form\CategorieCollectType', $categorieCollect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorieCollect);
            $em->flush();

            return $this->redirectToRoute('categoriecollect_index');
        }

        return $this->render('categoriecollect/new.html.twig', array(
            'categorieCollect' => $categorieCollect,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorieCollect entity.
     *
     */
    public function showAction(CategorieCollect $categorieCollect)
    {
        $deleteForm = $this->createDeleteForm($categorieCollect);

        return $this->render('categoriecollect/show.html.twig', array(
            'categorieCollect' => $categorieCollect,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorieCollect entity.
     *
     */
    public function editAction(Request $request, CategorieCollect $categorieCollect)
    {
        $deleteForm = $this->createDeleteForm($categorieCollect);
        $editForm = $this->createForm('CollecteBundle\Form\CategorieCollectType', $categorieCollect);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categoriecollect_edit', array('typeCategorie' => $categorieCollect->getTypecategorie()));
        }

        return $this->render('categoriecollect/edit.html.twig', array(
            'categorieCollect' => $categorieCollect,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categorieCollect entity.
     *
     */
    public function deleteAction(Request $request, CategorieCollect $categorieCollect)
    {
        $form = $this->createDeleteForm($categorieCollect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorieCollect);
            $em->flush();
        }

        return $this->redirectToRoute('categoriecollect_index');
    }

    /**
     * Creates a form to delete a categorieCollect entity.
     *
     * @param CategorieCollect $categorieCollect The categorieCollect entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategorieCollect $categorieCollect)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoriecollect_delete', array('typeCategorie' => $categorieCollect->getTypecategorie())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
