<?php

namespace App\Controller\Admin;

use App\Entity\Blog\BlogArticle;
use App\Entity\Blog\BlogCategorie;
use App\Entity\Blog\BlogCommentaire;
use App\Entity\Carrier;
use App\Entity\Categories;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {


        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
        // $routeBuilder = $this->container->get(CrudUrlGenerator::class)->build();

        return $this->redirect($adminUrlGenerator->setController(OrderCrudController::class)->generateUrl());

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
            ->setTitle('La boutique Française');
    }

    // public function configureCrud(): Crud
    // {
    //     return Crud::new()
    //         // ...
    //
    //         // the first argument is the "template name", which is the same as the
    //         // Twig path but without the `@EasyAdmin/` prefix
    //         ->overrideTemplate('label/null', 'admin/labels/my_null_label.html.twig')
    //
    //         ->overrideTemplates([
    //             'crud/index' => 'bundles/EasyAdminBundle/admin/pages/index.html.twig',
    //             'crud/field/textarea' => 'admin/fields/dynamic_textarea.html.twig',
    //         ])
    //         ;
    // }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('E-commerce');
        yield MenuItem::linkToCrud('Orders', 'fas fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Categories::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-barcode', Product::class);
        yield MenuItem::linkToCrud('Carriers', 'fas fa-truck', Carrier::class);
        yield MenuItem::section('Blogs');
        yield MenuItem::linkToCrud('Articles', 'fas fa-truck', BlogArticle::class);
        yield MenuItem::linkToCrud('Catégorie Articles', 'fas fa-truck', BlogCategorie::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-truck', BlogCommentaire::class);
        yield MenuItem::section('Les utilisateurs');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
    }
}
