<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Car;
use App\Entity\CityDropoffLocation;
use App\Entity\CityPickupLocation;
use App\Entity\Location;
use App\Entity\Option;
use App\Entity\Pack;
use App\Entity\Payment;
use App\Entity\Status;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CarCrudController::class)->generateUrl());
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('assets/css/admin_dashboard.css');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="/assets/images/logoautorent.png" alt="Autorent" ">')
            ->setFaviconPath('/assets/images/favicon.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-tachometer-alt custom-icon-size');
        yield MenuItem::linkToCrud('Véhicules', 'fas fa-car custom-icon-size', Car::class);
        yield MenuItem::linkToCrud('Ville de départ', 'fas fa-map-marker-alt custom-icon-size', CityPickupLocation::class);
        yield MenuItem::linkToCrud('Ville de retour', 'fas fa-map-marker-alt custom-icon-size', CityDropoffLocation::class);
        yield MenuItem::linkToCrud('Locations', 'fas fa-book custom-icon-size', Location::class);
        yield MenuItem::linkToCrud('Options', 'fas fa-cogs custom-icon-size', Option::class);
        yield MenuItem::linkToCrud('Packs', 'fas fa-box custom-icon-size', Pack::class);
        yield MenuItem::linkToCrud('Paiement', 'fas fa-credit-card custom-icon-size', Payment::class);
        yield MenuItem::linkToCrud('Statuts', 'fas fa-info-circle custom-icon-size', Status::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users custom-icon-size', User::class);
    }
}
