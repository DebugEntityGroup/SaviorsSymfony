<?php

namespace ReclamationBundle\Controller;

use ReclamationBundle\Entity\Recherche;
use ReclamationBundle\Entity\Reclamation;
use ReclamationBundle\Entity\ReclamationPending;
use ReclamationBundle\Form\RechercheType;
use ReclamationBundle\ReclamationBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Reclamation controller.
 *
 */
class ReclamationController extends Controller
{
    /**
     * Lists all reclamationPending entities.
     *
     */
    public function indexAction(Request $request)
    {
        $recherche = new Recherche();
        $form=$this->createForm(RechercheType::class, $recherche);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $recherche=$this->getDoctrine()->getRepository(ReclamationPending::class)->findBy(array('objet'=>$recherche->getObjet()));
        } else {
            $recherche=$this->getDoctrine()->getRepository(ReclamationPending::class)->findAll();
        }

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         *
         */
        $paginator = $this->get('knp_paginator');
      $result= $paginator->paginate(
          $recherche,
           $request->query->getInt('page',1),
           $request->query->getInt('limet',2)

       );
        return $this->render('reclamation/index.html.twig', array(
            'result' => $result,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new reclamation entity.
     *
     */
    public function newAction(Request $request)
    {
        $reclamation = new Reclamation();
        $form = $this->createForm('ReclamationBundle\Form\ReclamationType', $reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $reclamation->setUser($this->getUser());
            $em->persist($reclamation);
            $em->flush();

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamation/new.html.twig', array(
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reclamationPending entity.
     *
     */
    public function showAction(ReclamationPending $reclamation)
    {
        $deleteForm = $this->createDeleteForm($reclamation);

        return $this->render('reclamation/show.html.twig', array(
            'reclamation' => $reclamation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reclamationPending entity.
     *
     */
    public function editAction(Request $request, ReclamationPending $reclamation)
    {
        $deleteForm = $this->createDeleteForm($reclamation);
        $editForm = $this->createForm('ReclamationBundle\Form\ReclamationPendingType', $reclamation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamation_edit', array('idR' => $reclamation->getId()));
        }

        return $this->render('reclamation/edit.html.twig', array(
            'reclamation' => $reclamation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reclamationPending entity.
     *
     */
    public function deleteAction(Request $request, ReclamationPending $reclamation)
    {
        $form = $this->createDeleteForm($reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reclamation);
            $em->flush();
        }

        return $this->redirectToRoute('reclamation_index');
    }

    /**c
     * Creates a form to delete a reclamation entity.
     *
     * @param ReclamationPending $reclamation The reclamation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ReclamationPending $reclamation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reclamation_delete', array('id' => $reclamation->getId())))
            ->setMethod('DELETE')
            ->getForm();


    }

    public function rechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $reclamation =  $em->getRepository('ReclamationBundle:Reclamation')->findEntitiesByString($requestString);
        if(!$reclamation) {
            $result['reclamation']['error'] = "Reclamation Not found  ";
        } else {
            $result['reclamation'] = $this->getRealEntities($reclamation);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($reclamation){
        foreach ($reclamation as $reclamation){
            $realEntities[$reclamation-> getId()] = [$reclamation->getObjet(),$reclamation->getDescription()];

        }
        return $realEntities;
    }





}
