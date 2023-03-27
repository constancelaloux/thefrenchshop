<?php

namespace App\Classe;
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
Use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Description of Search
 *
 * @author constancelaloux
 */
class Cart 
{
    public function __construct(private RequestStack $requestStack) {
        $this->session = $requestStack->getSession();
    }

    
    public function add($id)
    {
        //$session = $this->requestStack->getSession();
        
        $cart = $this->session->get('cart', []);
        
        if(!empty($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        
        // stores an attribute for reuse during a later user request
        $this->session->set('cart', $cart);
    }
    
    public function get()
    {
        //$session = $this->requestStack->getSession();
        // gets an attribute by name
        return $this->session->get('cart');
    }
    
    public function remove()
    {
        //$session = $this->requestStack->getSession();
        return $this->session->remove('cart');
    }
}