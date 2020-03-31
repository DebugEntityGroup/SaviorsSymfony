<?php

namespace ProduitBundle\Controller;

use ProduitBundle\Entity\Produit;
use ProduitBundle\Entity\Produitcomment;
use ProduitBundle\Entity\ProduitPending;
use ProduitBundle\Form\ProduitcommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ProduitBundle\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Produit controller.
 *
 */
class ProduitController extends Controller
{
    /**
     * Lists all produitPending entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $q = $request->get('q', null);
        $category = $request->get('category', null);
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 5);
        $produits = new ProduitPending();
        $categories = $em->getRepository('ProduitBundle:Categorie')->findAll();

        if (empty($q) && empty($category)) {

            $produits = $em->getRepository('ProduitBundle:ProduitPending')->findAll();
            $produits = $this->get('knp_paginator')->paginate(
                $produits,
                $request->query->get('page', 1)/*le numéro de la page à afficher*/,
                8);
        } elseif (empty($category)) {
            $produits = $this->getDoctrine()->getRepository(ProduitPending::class)->NameFilter($q);
            $produits = $this->get('knp_paginator')->paginate(
                $produits,
                $request->query->get('page', 1)/*le numéro de la page à afficher*/,
                8);
        } elseif (empty($q)) {
            $produits = $this->getDoctrine()->getRepository(ProduitPending::class)->CategoryFilter($category);
            $produits = $this->get('knp_paginator')->paginate(
                $produits,
                $request->query->get('page', 1)/*le numéro de la page à afficher*/,
                8);
        } else {
            $produits = $this->getDoctrine()->getRepository(ProduitPending::class)->DeepFilter($q, $category);
            $produits = $this->get('knp_paginator')->paginate(
                $produits,
                $request->query->get('page', 1)/*le numéro de la page à afficher*/,
                8);
        }

        return $this->render('produit/index.html.twig', array(
            'produits' => $produits,
            'categories' => $categories,
            'category' => $category,
            'search' => $q,
        ));
    }




    /**
     * Creates a new produit entity.
     *
     */
    public function newAction(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm('ProduitBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produitPending entity.
     *
     */
    public function showAction(Request $request, ProduitPending $produit)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = new Produitcomment();
        $form=$this->createForm(ProduitcommentType::class, $commentaire);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
            $commentaire->setProduitPending($produit);
            $commentaire->setUser($this->getUser());
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('produit_show', array('id'=> $produit->getId()));
        }
        $comments = $em->getRepository(Produitcomment::class)->findBy(array('user'=>$this->getUser(), 'produitPending'=>$produit));
        $produitP = $this->getDoctrine()->getRepository(ProduitPending::class)->find($produit->getId());
        return $this->render('produit/show.html.twig', array(
            'produitP' => $produitP,
            'commentaire' => $commentaire,
            'comments' => $comments,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing produitPending entity.
     *
     */
    public function editAction(Request $request, ProduitPending $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('ProduitBundle\Form\ProduitPendingType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_edit', array('id' => $produit->getId()));
        }

        return $this->render('produit/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produitPending entity.
     *
     */
    public function deleteAction(Request $request, ProduitPending $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produit_index');
    }

    /**
     * Creates a form to delete a produitPending entity.
     *
     * @param ProduitPending $produit The produitPending entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProduitPending $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produit_delete', array('id' => $produit->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function searchAction(Request $request)
    {
        $produits = new ProduitPending();
        $em = $this->getDoctrine()->getManager();
        $q = $request->get('q');
        var_dump($q);
        $produits = $this->getDoctrine()->getRepository(ProduitPending::class)->findEntitiesByString($q);
        if (!$produits) {
            $result['produits']['error'] = "produits Not found :( ";
        } else {
            $result['produits'] = $this->getRealEntities($produits);
        }
        return new Response(json_encode($result));
    }


    public function getRealEntities($produits)
    {
        foreach ($produits as $produits) {
            $realEntities[$produits->getId()] = [$produits->getImage(), $produits->getNom()];

        }
        return $realEntities;
    }

    public function mesProduitsAction() {
        $produits=$this->getDoctrine()->getManager()->getRepository(ProduitPending::class)->findAll();
        return $this->render('produit/mesproduits.html.twig', array(
            'produits' => $produits,
        ));
    }
}