<?php

namespace SaviorsBundle\Controller;

use PublicationBundle\Entity\Aime;
use PublicationBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function newsAction(Request $request)
    {
        $news = $this -> getDoctrine() -> getManager() -> getRepository(Publication::class) -> search($request->get('keywords', ''));
        return $this -> render('@Saviors/front/User/news.html.twig', [
            'news' => $news
        ]);
    }

    public function setLikeStatusAction($id)
    {
        $publication = $this->getDoctrine()->getManager()->getRepository(Publication::class)->find($id);
        $like = null;
        foreach ($publication->getLikes() as $lik) {
            if($lik->getUser() === $this->getUser()) {
                $like = $lik;
                break;
            }
        }
        if($like) $publication->removeLike($like);
        else {
            $like = new Aime();
            $like->setUser($this->getUser());
            $like->addPublication($publication);
            $this->getDoctrine()->getManager()->persist($like);
        }
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('news');
    }

    public function aboutAction() {
        return $this->render('@Saviors/Front/User/about.html.twig');
    }

    public function coursesDetailAction() {
        return $this->render('@Saviors/Front/User/courses_detail.html.twig');
    }

    public function elementsAction() {
        return $this->render('@Saviors/Front/User/elements.html.twig');
    }

    public function blogAction() {
        return $this->render('@Saviors/Front/User/blog.html.twig');
    }

    public function single_blogAction() {
        return $this->render('@Saviors/Front/User/single_blog.html.twig');
    }

    public function contactAction() {
        return $this->render('@Saviors/Front/User/contact.html.twig');
    }

    public function loginAction() {
        return $this->render('@Saviors/Front/User/login.html.twig');
    }

    public function signupAction() {
        return $this->render('@Saviors/Front/User/login.html.twig');
    }
}
