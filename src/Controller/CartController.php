<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Classe\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractController
{
    private object $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/cart', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig',
                [
                    'cart' => $cart->cartGetFull()
                ]);
    }
    
    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, int $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('app_cart');
    }
    
    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('app_products');
    }
    
    #[Route('/cart/delete/{id}', name: 'delete_my_cart')]
    public function delete(Cart $cart, int $id): Response
    {
        $cart->delete($id);
        return $this->redirectToRoute('app_cart');
    }
    
    #[Route('/cart/decrease/{id}', name: 'decrease_my_cart')]
    public function decrease(Cart $cart, int $id): Response
    {
        $cart->decrease($id);
        return $this->redirectToRoute('app_cart');
    }
}
