<?php

namespace App\Classe;
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
Use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of Search
 *
 * @author constancelaloux
 */
class Cart 
{
    private object $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager, private RequestStack $requestStack) 
    {
        $this->entityManager = $entityManager;
    }

    public function add(int $id): Void
    {
        $session = $this->requestStack->getSession();
        
        $cart = $session->get('cart', []);
        
        if(isset($cart[$id]))
        {
            if(!empty($cart[$id]))
            {
                $cart[$id]++;
            } else 
            {
                $cart[$id] = 1;
            }
        }
        
        // stores an attribute for reuse during a later user request
        $session->set('cart', $cart);
    }
    
    public function get(): array
    {
        $session = $this->requestStack->getSession();
        // gets an attribute by name
        return $session->get('cart');
    }
    
    public function remove(): Response
    {
        $session = $this->requestStack->getSession();
        return $session->remove('cart');
    }
       
    public function delete(int $id): ?Response
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        unset($cart[$id]);
        return $session->set('cart', $cart);
    }
    
    public function decrease(int $id): ?Response
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        if(isset($cart[$id])){
            $cart[$id] --;
            if(($cart[$id]) === 0)
            {
                unset($cart[$id]);
            }
        }
        return $session->set('cart', $cart);
    }
    
    public function cartGetFull(): array
    {
        $cartComplete = [];
        
        if($this->get())
        {
            foreach($this->get() as $id => $quantity)
            {
                $productObject = $this->entityManager->getRepository(Product::class)->findOneById($id);
                if(!$productObject){
                    $this->delete($id);
                    continue;
                }
                $cartComplete[] = [
                    'product' => $this->entityManager->getRepository(Product::class)->findOneById($id),
                    'quantity' => $quantity
                ];
            }
        }
        return $cartComplete;
    }
}