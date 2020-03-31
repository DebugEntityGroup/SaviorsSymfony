<?php

namespace CollecteBundle\Controller;

use CollecteBundle\Entity\Collect;
use CollecteBundle\Entity\CollectPending;
use CollecteBundle\Entity\Commentaire;
use CollecteBundle\Entity\Don;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Collect controller.
 *
 */
class CollectController extends Controller
{
    /**
     * Lists all collectPending entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $collects = $em->getRepository('CollecteBundle:CollectPending')->findAll();

        return $this->render('collect/index.html.twig', array(
            'collects' => $collects,
        ));
    }

    /**
     * Creates a new collect entity.
     *
     */
    public function newAction(Request $request)
    {
        $collect = new Collect();
        $form = $this->createForm('CollecteBundle\Form\CollectType', $collect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $collect->setUser($this->getUser());
            $em->persist($collect);
            $em->flush();

            return $this->redirectToRoute('collect_index');
        }

        return $this->render('collect/new.html.twig', array(
            'collect' => $collect,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a collectPending entity.
     *
     */
    public function showAction(CollectPending $collect)
    {
        $deleteForm = $this->createDeleteForm($collect);

        return $this->render('collect/show.html.twig', array(
            'collect' => $collect,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing collectPending entity.
     *
     */
    public function editAction(Request $request, CollectPending $collect)
    {
        $deleteForm = $this->createDeleteForm($collect);
        $editForm = $this->createForm('CollecteBundle\Form\CollectPendingType', $collect);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('collect_edit', array('id' => $collect->getId()));
        }

        return $this->render('collect/edit.html.twig', array(
            'collect' => $collect,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a collectPending entity.
     *
     */
    public function deleteAction(Request $request, CollectPending $collect)
    {
        $form = $this->createDeleteForm($collect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($collect);
            $em->flush();
        }

        return $this->redirectToRoute('collect_index');
    }

    /**
     * Creates a form to delete a collectPending entity.
     *
     * @param Collect $collect The collectPending entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CollectPending $collect)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('collect_delete', array('id' => $collect->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function supprimerCollectAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $collect = $em->getRepository(CollectPending::class)->findOneBy(array(
            'id' => $id
        ));
        $em->remove($collect);
        $em->flush();
        return $this->redirectToRoute("collect_index");
    }

    public function listeCollecteAction()
    {
        $em = $this->getDoctrine()->getManager();

        $collectes = $em->getRepository('CollecteBundle:CollectPending')->findAll();

        return $this->render('collect/listeCategories.html.twig', array(
            'collectes' => $collectes,
        ));
    }

    public function detailsCollecteAction(Request $request, CollectPending $collectPending)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = new Commentaire();
        $form = $this->createForm('CollecteBundle\Form\CommentaireType', $commentaire);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $commentaire->setCollectPending($collectPending);
            $commentaire->setUser($this->getUser());
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('collect_details', array('id' => $collectPending->getId()));
        }
        $comments = $em->getRepository(Commentaire::class)->findBy(['user' => $this->getUser(), 'collectPending' => $collectPending]);
        $collecteP = $this->getDoctrine()->getRepository(CollectPending::class)->find($collectPending->getId());
        return $this->render('collect/detailsCollecte.html.twig', array(
            'collecteP' => $collecteP,
            'commentaire' => $commentaire,
            'comments' => $comments,
            'form' => $form->createView(),
        ));
    }

    public function faireUnDonAction(Request $request, CollectPending $collectPending)
    {
        $em = $this->getDoctrine()->getManager();
        $collectP = $this->getDoctrine()->getRepository(CollectPending::class)->find($collectPending->getId());
        $don = new Don();
        $dons = $this->getDoctrine()->getManager()->getRepository(Don::class)->findAll();
        $form = $this->createForm('CollecteBundle\Form\DonType', $don);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $don->setCollectPending($collectPending->setNombreAtteint($don->getMoneyDonated() + $collectPending->getNombreAtteint()));
            $don->setCollectPending($collectPending->setNombreParticipantsCollecte($collectPending->getNombreParticipantsCollecte() + 1));
            while ($collectPending->getBudgetCollecte() >= $collectPending->getNombreAtteint()) {
                $don->setUser($this->getUser());
                $don->setDateHour(new \DateTime('now'));
                $em->persist($don);
                $em->flush();
                return $this->redirectToRoute('collect_details', array('id' => $collectPending->getId()));
            }
            while ($collectPending->getBudgetCollecte() < $collectPending->getNombreAtteint()) {
                return $this->redirectToRoute('faireundon', array('id' => $collectPending->getId()));
            }
        }
        return $this->render('collect/ajouterUnFond.html.twig', array(
            'collecteP' => $collectP,
            'don' => $don,
            'donations' => $dons,
            'form' => $form->createView(),
        ));
    }

    public function showByCatAction($typeCategorie) {
        $collectPendingR = $this->getDoctrine()->getManager()->getRepository('CollecteBundle:CollectPending');
        $collections = $collectPendingR->showByCat($typeCategorie);
        return $this->render('collect/collectParCat.html.twig', array(
            'collections' => $collections,
        ));
    }
}
