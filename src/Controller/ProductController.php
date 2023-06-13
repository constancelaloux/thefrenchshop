<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Classe\Search;
use App\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    private object $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/products', name: 'app_products')]
    public function index(Request $request): Response
    {    
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid())
        {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }
        else
        {
            $products = $this->entityManager->getRepository(Product::class)->findAll();
            if (!$products) 
            {
                throw $this->createNotFoundException(
                    'No product found'
                );
            }
        }
        
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }
    
    
    #[Route('/product/{slug}', name: 'product')]
    public function show(string $slug): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);

        if (!$product) {
            return $this->redirectToRoute('app_products');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
