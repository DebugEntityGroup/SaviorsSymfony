<?php

namespace ReclamationBundle\Controller;

use CollecteBundle\Entity\CollectPending;
use ReclamationBundle\Entity\Raisons;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Raison controller.
 *
 */
class RaisonsController extends Controller
{
    /**
     * Lists all raison entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $raisons = $em->getRepository('ReclamationBundle:Raisons')->findAll();

        return $this->render('raisons/index.html.twig', array(
            'raisons' => $raisons,
        ));
    }

    /**
     * Creates a new raison entity.
     *
     */
    public function newAction(Request $request)
    {
        $raison = new Raisons();
        $form = $this->createForm('ReclamationBundle\Form\RaisonsType', $raison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($raison);
            $em->flush();

            return $this->redirectToRoute('raisons_show', array('typeRaison' => $raison->getTypeRaison()));
        }

        return $this->render('raisons/new.html.twig', array(
            'raison' => $raison,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a raison entity.
     *
     */
    public function showAction(Raisons $raison)
    {
        $deleteForm = $this->createDeleteForm($raison);

        return $this->render('raisons/show.html.twig', array(
            'raison' => $raison,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing raison entity.
     *
     */
    public function editAction(Request $request, Raisons $raison)
    {
        $deleteForm = $this->createDeleteForm($raison);
        $editForm = $this->createForm('ReclamationBundle\Form\RaisonsType', $raison);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('raisons_edit', array('id' => $raison->getTypeRaison()));
        }

        return $this->render('raisons/edit.html.twig', array(
            'raison' => $raison,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a raison entity.
     *
     */
    public function deleteAction(Request $request, Raisons $raison)
    {
        $form = $this->createDeleteForm($raison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($raison);
            $em->flush();
        }

        return $this->redirectToRoute('raisons_index');
    }

    /**
     * Creates a form to delete a raison entity.
     *
     * @param Raisons $raison The raison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Raisons $raison)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('raisons_delete', array('typeRaison' => $raison->getTypeRaison())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function supprimerRaisonAction($typeRaison)
    {
        $em = $this->getDoctrine()->getManager();
        $raison = $em->getRepository(Raisons::class)->findOneBy(array(
            'typeRaison' => $typeRaison
        ));
        $em->remove($raison);
        $em->flush();
        return $this->redirectToRoute("raisons_index");
    }
}
