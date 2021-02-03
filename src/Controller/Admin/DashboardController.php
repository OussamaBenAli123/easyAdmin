<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(PostCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Easy Admin Test');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::subMenu('Posts','fa fa-file-pdf')->setSubItems([
            MenuItem::linkToCrud('Add','fa fa-plus',Post::class)->setAction('new'),
            MenuItem::linkToCrud('List','fa fa-list',Post::class)->setAction('index')
        ]);
        yield MenuItem::linkToCrud('Categories', 'fas fa-file-word', Category::class);
    }

    public function configureCrud(): Crud
    {
        return Crud::new()->overrideTemplates([
            'crud/index'    =>  'admin/posts/index.html.twig',
            'crud/new'      =>  'admin/posts/new.html.twig',
            'crud/action'   =>  'admin/posts/action.html.twig',
            'main_menu'     =>  'admin/menu.html.twig',
            'crud/paginator'     =>  'admin/paginator.html.twig'
            ])->setPaginatorPageSize(5);
    }
}
