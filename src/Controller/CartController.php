<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Classe\Cart;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class CartController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    
    #[Route('/cart', name: 'app_cart')]
    public function index(Cart $cart)
    {
        $cartComplete = [];
        
        foreach($cart->get() as $id => $quantity){
            $cartComplete[] = [
                'product' => $this->entityManager->getRepository(Product::class)->findOneById($id),
                'quantity' => $quantity
            ];
        }
        return $this->render('cart/index.html.twig',
                [
                    'cart' => $cartComplete
                ]);
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
    
    #[Route('/cart/delete/{id}', name: 'delete_my_cart')]
    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);
        return $this->redirectToRoute('app_cart');
    }
    
    #[Route('/cart/decrease/{id}', name: 'delete_my_cart')]
    public function decrease(Cart $cart, $id)
    {
        $$cart - 1;
        return $this->redirectToRoute('app_cart');
    }
}
