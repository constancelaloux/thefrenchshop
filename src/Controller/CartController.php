<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classe\Cart;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(Cart $cart)
    {
        dd($cart->get());
        return $this->render('cart/index.html.twig');
    }
    
    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id)
    {;
        $cart->add($id);
        return $this->redirectToRoute('app_cart');
    }
    
    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Cart $cart)
    {
        $cart->remove();
        return $this->redirectToRoute('app_products');
    }
}
