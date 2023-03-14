<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Category;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator){
        
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        //$adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        //return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
        $url = $this->adminUrlGenerator
                ->setController(UserCrudController::class)
                ->generateUrl();
        return $this->redirect($url);
        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Thefrenchshop');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::section('E-commerce');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Product', 'fas fa-list', Product::class)
                ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Product', 'fas fa-tag', Product::class)
        ]);
         yield MenuItem::subMenu('Catégories', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Catégorie', 'fas fa-list', Product::class)
                ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Product', 'fas fa-tag', Product::class)
        ]);
        //yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        //yield MenuItem::linkToCrud('Products', 'fas fa-tag', Product::class);
    }
}
