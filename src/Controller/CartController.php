<?php


namespace App\Controller;


use App\Service\Cart\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends abstractController
{

    /**
     * @Route("/library/panier", name="cart_index")
     */

    public function index(CartService $cartService){
        $cartData= $cartService->getFullCart();

        return $this->render('Cart/index.html.twig',[
           'items'=>$cartData
        ]);
    }

    /**
     * @Route("/library/panier/add/{id}", name="cart_add")
     */

    public function add($id,CartService $cartService){
        $cartService->add($id);

        return $this->redirectToRoute("cart_index");

    }
}