<?php

namespace App\Controller\Admin\E_commerce;

use App\Entity\BlogArticles;
use App\Entity\BlogCategory;
use App\Entity\BlogCommentaire;
use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Page;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        //Route par défaut
        //return parent::index();

        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(OrderCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Bionutri');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Utilisateur');
        yield MenuItem::linktoDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Commande', 'fa fa-shopping-cart', Order::class);



        yield MenuItem::section('Boutique');
        yield MenuItem::linkToCrud('Categories', 'fa fa-list', Category::class);
        yield MenuItem::linkToCrud('Produits', 'fa fa-tag', Product::class);
        yield MenuItem::linkToCrud('Page', 'fa fa-tag', Page::class);
        yield MenuItem::linkToCrud('Carrier', 'fa fa-truck', Carrier::class);


        yield MenuItem::section('Blog');
        yield MenuItem::linkToCrud('Articles', null, BlogArticles::class);
        yield MenuItem::linkToCrud('Commentaires', null, BlogCommentaire::class);
        yield MenuItem::linkToCrud('Categories', null, BlogCategory::class);

    }
}
