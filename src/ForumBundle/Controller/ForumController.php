<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\CategorieForum;
use ForumBundle\Entity\CommentaireF;
use ForumBundle\Entity\Forum;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Forum controller.
 *
 */
class ForumController extends Controller
{


    /**
     * Lists all forum entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $forums = $em->getRepository('ForumBundle:Forum')->findAll();
        $forums = $this->get('knp_paginator')->paginate(
            $forums,
            $request->query->get('page',1),
        1);
        return $this->render('forum/index.html.twig', array(
            'forums' => $forums,
        ));
    }
    public function usershowAction()
    {
        $em = $this->getDoctrine()->getManager();

        $forums = $em->getRepository('ForumBundle:Forum')->findAll();

        return $this->render('forum/usershow.html.twig', array(
            'forums' => $forums,
        ));
    }

    /**
     * Creates a new forum entity.
     *
     */
    public function newAction(Request $request)
    {
        $forum = new Forum();
        $form = $this->createForm('ForumBundle\Form\ForumType', $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $forum->setUser($this->getUser());
            $em->persist($forum);
            $em->flush();

            return $this->redirectToRoute('forum_show', array('id' => $forum->getId()));
        }

        return $this->render('forum/new.html.twig', array(
            'forum' => $forum,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a forum entity.
     *
     */
    public function showAction(Forum $forum, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $commentaire =new CommentaireF();
        $form=$this->createForm('ForumBundle\Form\CommentaireFType', $commentaire);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
            $commentaire->setForum($forum);
            $commentaire->setUser($this->getUser());
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('forum_show', array('id'=>$forum->getId()));
        }
        $comments=$em->getRepository(CommentaireF::class)->findBy(['user'=>$this->getUser(), 'forum'=>$forum]);
        $forumm=$this->getDoctrine()->getRepository(Forum::class)->find($forum->getId());

        return $this->render('forum/show.html.twig', array(
            'forum' => $forum,
            'forumm' => $forumm,
            'comments' => $comments,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing forum entity.
     *
     */
    public function editAction(Request $request, Forum $forum)
    {
        $deleteForm = $this->createDeleteForm($forum);
        $editForm = $this->createForm('ForumBundle\Form\ForumType', $forum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('forum_edit', array('id' => $forum->getId()));
        }

        return $this->render('forum/edit.html.twig', array(
            'forum' => $forum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a forum entity.
     *
     */
    public function deleteAction(Request $request, Forum $forum)
    {
        $form = $this->createDeleteForm($forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($forum);
            $em->flush();
        }

        return $this->redirectToRoute('forum_index');
    }


    public function paginationAction(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
{
    $dql   = "SELECT f FROM Bundle:Forum f";
    $query = $em->createQuery($dql);

    $pagination = $paginator->paginate(
        $query, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        10 /*limit per page*/
    );

    // parameters to template
    return $this->render('forum/pagination.html.twig', ['pagination' => $pagination]);
}

    /**
     * Creates a form to delete a forum entity.
     *
     * @param Forum $forum The forum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Forum $forum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('forum_delete', array('id' => $forum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function findQuestionsByCatAction($id)
    {
        $forum = $this->getDoctrine()->getManager()->getRepository(Forum::class);
        $collections = $forum->findQuestionByCat($id);
        return $this->render('forum/firstindex.html.twig', array(
            'collections' => $collections,
        ));
    }

    public function mesforumAction()
    {
        $em = $this->getDoctrine()->getManager();

        $forums = $em->getRepository('ForumBundle:Forum')->findAll();

        return $this->render('forum/mesforum.html.twig', array(
            'forums' => $forums,
        ));
    }

    public function bubbleAction()
    {
        return $this->render('forum/bubble2.html.twig');

    }




}
