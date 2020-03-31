<?php

namespace AssocBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use AssocBundle\Entity\Comment;
use AssocBundle\Entity\Event;
use AssocBundle\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
 * Event controller.
 *
 */
class EventController extends Controller
{
    /**
     * Lists all event entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AssocBundle:EventPending')->findAll();

        return $this->render('event/index.html.twig', array(
            'events' => $events,
        ));
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $events = [];
        if ($request->isMethod('POST')) {

           $mot = $request->request->get('mot');
            $events = $em->getRepository('AssocBundle:Event')->findByMot($mot);

        }


        return $this->render('event/index.html.twig', array(
            'events' => $events,
        ));
    }

    public function listEventAction()
    {
        $em = $this->getDoctrine()->getManager();
       // $eventsTab =[] ;
        $repos = $em->getRepository('AssocBundle:Event');
        $events= $repos->createQueryBuilder('c')
            ->getQuery()
            ->getArrayResult();
        $ev = [];
        $tab = [];


        foreach ($events as $event) {
            $ev['title'] = $event['name'];
            $ev['start'] = $event['Dateevent']->format('Y-m-d H:i:s');
            $tab[] = $ev;
        }
        return $response = new JsonResponse($tab);

    }

    /**
     * Creates a new event entity.
     *
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('AssocBundle\Form\EventType', $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_index');
        }
        return $this->render('event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a event entity.
     *
     */
    public function showAction(Request $request, Event $event)
    {

       if($event->getStatus() != "visible" ) {
           throw $this->createNotFoundException('The event does not exist');
       }
        $em = $this->getDoctrine()->getManager();

        $comment = new Comment();
        $form = $this->createForm('AssocBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setEvent($event);
            $comment->setUser($this->getUser());
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        $rating = new Rating();
        $formRating = $this->createForm('AssocBundle\Form\RatingType', $rating);
        $formRating->handleRequest($request);

        if ($formRating->isSubmitted() && $formRating->isValid()) {
            $rating->setEvent($event);
            $rating->setUser($this->getUser());


            $em->persist($rating);
            $em->flush();
            $notes = $event->getRatings();
            $count = count($notes);
            $somme = 0;
            foreach ($notes as $note) {
                $somme += $note->getNote();
            }
            $event->setMoyenne( $somme / $count);
            $em->flush();
            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        $comments = $em->getRepository('AssocBundle:Comment')->findBy(['user' => $this->getUser(), 'event' => $event]);

        return $this->render('event/show.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
            'comments' => $comments,
             'formRating' => $formRating->createView(),

        ));
    }

    public function interestedAction(Event $event)
    {
        $comment = new Comment();
        $form = $this->createForm('AssocBundle\Form\CommentType', $comment);
        $rating = new Rating();
        $formRating = $this->createForm('AssocBundle\Form\RatingType', $rating);
        $event->setNbrInterest($event->getNbrInterest() + 1);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('AssocBundle:Comment')->findBy(['user' => $this->getUser(), 'event' => $event]);

        return $this->render('event/show.html.twig', array(
            'event' => $event,'form' => $form->createView(),
             'formRating' => $formRating->createView(),'comments'=>$comments

        ));

    }

    /**
     * Displays a form to edit an existing event entity.
     *
     */
    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('AssocBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_edit', array('id' => $event->getId()));
        }

        return $this->render('event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     *
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
