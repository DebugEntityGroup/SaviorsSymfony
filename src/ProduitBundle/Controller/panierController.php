<?php

namespace ProduitBundle\Controller;

use ProduitBundle\Entity\ProduitPending;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class panierController extends Controller
{

    public function panierAction(SessionInterface $session )
    {
        $em=$this->getDoctrine()->getManager();
        $product=$em->getRepository(ProduitPending::class);
        $panier = $session->get('panier',[]);
        $panierWithData = [];
        foreach ($panier as $id=>$quantity)
        {
            $panierWithData[]=[
                'product'=> $product->find($id),
                'quantity' => $quantity
            ];
        }
        $total =0;

        foreach ($panierWithData as $item)
        {
            $totalItem = $item['product']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }

        dump($panierWithData);

        return $this->render('panier/indexpanier.html.twig',[
            'items'=> $panierWithData,
            'total' => $total
        ]);
    }
    public function addPanierAction($id,SessionInterface $session)
    {
        $panier = $session->get('panier',[]);

        if (!empty($panier[$id]))
        {
            $panier[$id]++;
        }
        else
        {
            $panier[$id] = 1;
        }

        $panier[$id] = 1;

        $session->set('panier',$panier);


        return $this->redirectToRoute('indexpanier');
    }
    public function removeAction($id,SessionInterface $session)
    {
        $panier = $session->get('panier',[]);
        if (!empty($panier[$id]))
        {
            unset($panier[$id]);
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('indexpanier');

    }

}
