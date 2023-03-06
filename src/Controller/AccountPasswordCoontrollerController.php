<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordCoontrollerController extends AbstractController
{
    #[Route('/account/password/coontroller', name: 'app_account_password_coontroller')]
    public function index(): Response
    {
        return $this->render('account/password.html.twig',);
    }
}
