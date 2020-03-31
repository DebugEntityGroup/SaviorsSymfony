<?php

namespace SaviorsBundle\Controller;

use AssocBundle\Entity\Event;
use CollecteBundle\Entity\CollectPending;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $collectes = $this->getDoctrine()->getManager()->getRepository(CollectPending::class)->findAll();
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $events = $this->getDoctrine()->getManager()->getRepository(Event::class)->findAll();
        return $this->render('@Saviors/Default/index.html.twig', array(
            'collectes' => $collectes,
            'users' => $users,
            'events' => $events,
        ));
    }
}
