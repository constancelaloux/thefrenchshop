<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $doctrine->getManager();
        $user = new User();
        
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()&& $form->isValid()){
            $user = $form->getData();
            $plaintextPassword = $user->getPassword();
            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($user);
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }
        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
