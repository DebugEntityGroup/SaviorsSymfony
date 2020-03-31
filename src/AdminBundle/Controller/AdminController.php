<?php

namespace AdminBundle\Controller;

use AssocBundle\Entity\EventPending;
use CollecteBundle\Entity\CollectPending;
use CollecteBundle\Entity\Commentaire;
use CollecteBundle\Entity\Don;
use ForumBundle\Entity\ForumPending;
use ProduitBundle\Entity\ProduitPending;
use ReclamationBundle\Entity\Reclamation;
use ReclamationBundle\Entity\ReclamationPending;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class AdminController extends Controller
{
    public function adminHomepageAction() {
        return $this->render('@Admin/Back/adminHomepage.html.twig');
    }

    public function adminForumsAction()
    {
        return $this->render('@Admin/Back/adminForums.html.twig');
    }
    public function adminProduitsAction()
    {
        return $this->render('@Admin/Back/adminProduits.html.twig');
    }
    public function adminPublicationAction()
    {
        return $this->render('@Admin/Back/adminPublication.html.twig');
    }
    public function adminReclamationAction()
    {
        return $this->render('@Admin/Back/adminReclamation.html.twig');
    }
    public function adminUserAction() {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('@Admin/Back/adminUser.html.twig', array(
            'users' => $users,
        ));
    }
    public function deleteUserAction($id) {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('admin_user');
    }

    public function listeForumsPendingAdminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $forums = $em->getRepository('ForumBundle:Forum')->findAll();
        return $this->render('@Admin/Back/adminForums.html.twig', array(
            'forums' => $forums,
        ));
    }

    public function listeForumsAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $forumsP = $em->getRepository('ForumBundle:ForumPending')->findAll();
        return $this->render('@Admin/Back/adminForums.html.twig', array(
            'forumsP' => $forumsP,
        ));
    }

    public function supprimerForumAction($id) {
        $em = $this->getDoctrine()->getManager();
        $forum= $em->getRepository('ForumBundle:Forum')->findOneBy(array(
            'id' => $id));
        $em->remove($forum);
        $em->flush();
        return $this->redirectToRoute("admin_forums");
   }


    public function listeEventsPendingAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('AssocBundle:Event')->findAll();
        return $this->render('@Admin/Back/adminEvents.html.twig', array(
            'events' => $events,
        ));
    }
    public function listeEventsAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $eventsP = $em->getRepository('AssocBundle:EventPending')->findAll();
        return $this->render('@Admin/Back/adminEvents.html.twig', array(
            'eventsP' => $eventsP,
        ));
    }

    public function supprimerEventAction($id) {
        $em = $this->getDoctrine()->getManager();
        $event= $em->getRepository('AssocBundle:Event')->findOneBy(array(
            'id' => $id));
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute("admin_event");
    }

    public function eventConfirmedAction($id) {
        $evenement = $this->getDoctrine()->getRepository('AssocBundle:Event')->find($id);
        $EventPending = new EventPending();

        $oldReflection = new \ReflectionObject($evenement);
        $newReflection = new \ReflectionObject($EventPending);

        foreach($oldReflection->getProperties() as $property) {
            $newProperty = $newReflection->getProperty($property->getName());
            $newProperty->setAccessible(true);
            $property->setAccessible(true);
            $newProperty->setValue($EventPending, $property->getValue($evenement));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($EventPending);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute("admin_event");
    }

    public function listeCollectePendingAdminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $collectes = $em->getRepository('CollecteBundle:Collect')->findAll();
        return $this->render('@Admin/Back/adminCollecte.html.twig', array(
            'collectes' => $collectes,
        ));
    }

    public function listeCollecteAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $collectesP = $em->getRepository('CollecteBundle:CollectPending')->findAll();
        return $this->render('@Admin/Back/adminCollecte.html.twig', array(
            'collectesP' => $collectesP,
        ));
    }

    public function supprimerCollecteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $collecte= $em->getRepository('CollecteBundle:Collect')->findOneBy(array(
            'id' => $id));
        $em->remove($collecte);
        $em->flush();
        return $this->redirectToRoute("admin_collect");
    }

    public function collecteConfirmedAction(Request $request, $id) {
        $collecte = $this->getDoctrine()->getRepository('CollecteBundle:Collect')->find($id);
        $CollectePending = new CollectPending();

        $oldReflection = new \ReflectionObject($collecte);
        $newReflection = new \ReflectionObject($CollectePending);

        foreach($oldReflection->getProperties() as $property) {
            $newProperty = $newReflection->getProperty($property->getName());
            $newProperty->setAccessible(true);
            $property->setAccessible(true);
            $newProperty->setValue($CollectePending, $property->getValue($collecte));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($CollectePending);
        $em->remove($collecte);
        $em->flush();
        return $this->redirectToRoute("admin_collecte");
    }

    /**
     * Lists all raison entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $raisons = $em->getRepository('ReclamationBundle:Raisons')->findAll();

        return $this->render('@Admin/Back/adminReclamation.html.twig', array(
            'raisons' => $raisons,
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

            return $this->redirectToRoute('raisons_edit', array('typeRaison' => $raison->getTypeRaison()));
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
            ->getForm();
    }


    public function listeReclamationsPendingAdminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reclamationsP = $em->getRepository(ReclamationPending::class)->findAll();
        return $this->render('@Admin/Back/adminReclamation.html.twig', array(
            'reclamationsP' => $reclamationsP,
        ));
    }

    public function listeReclamationsAdminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reclamations = $em->getRepository('ReclamationBundle:Reclamation')->findAll();
        return $this->render('@Admin/Back/adminReclamation.html.twig', array(
            'reclamations' => $reclamations,
        ));
    }

    public function supprimerReclamationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->findOneBy(array(
            'idR' => $id));
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("admin_reclamation");
    }

    public function reclamationConfirmedAction(Request $request, $id)
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $ReclamationPending = new ReclamationPending();

        $oldReflection = new \ReflectionObject($reclamation);
        $newReflection = new \ReflectionObject($ReclamationPending);

        foreach ($oldReflection->getProperties() as $property) {
            $newProperty = $newReflection->getProperty($property->getName());
            $newProperty->setAccessible(true);
            $property->setAccessible(true);
            $newProperty->setValue($ReclamationPending, $property->getValue($reclamation));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($ReclamationPending);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("admin_reclamation");
    }
    public function listeProduitsPendingAdminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ProduitBundle:Produit')->findAll();
        return $this->render('@Admin/Back/adminProduits.html.twig', array(
            'produits' => $produits,
        ));
    }

    public function listeProduitsAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $produitsP = $em->getRepository('ProduitBundle:ProduitPending')->findAll();
        return $this->render('@Admin/Back/adminProduits.html.twig', array(
            'produitsP' => $produitsP,
        ));
    }

    public function supprimerProduitAction($id) {
        $em = $this->getDoctrine()->getManager();
        $produit= $em->getRepository('ProduitBundle:Produit')->findOneBy(array(
            'id' => $id));
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("admin_produits");
    }

    public function produitConfirmedAction(Request $request, $id) {
        $produit = $this->getDoctrine()->getRepository('ProduitBundle:Produit')->find($id);
        $ProduitPending = new ProduitPending();

        $oldReflection = new \ReflectionObject($produit);
        $newReflection = new \ReflectionObject($ProduitPending);

        foreach($oldReflection->getProperties() as $property) {
            $newProperty = $newReflection->getProperty($property->getName());
            $newProperty->setAccessible(true);
            $property->setAccessible(true);
            $newProperty->setValue($ProduitPending, $property->getValue($produit));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($ProduitPending);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("admin_produits");
    }

    public function getAllCollectsAction() {
        $collectes = $this->getDoctrine()->getManager()->getRepository(CollectPending::class)->findAll();
        return $this->render('@Admin/Back/adminAllCollects.html.twig', array(
            'collectes' => $collectes
        ));
    }

}
