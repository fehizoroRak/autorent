<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Entity\CityDropoffLocation;
use App\Entity\CityPickupLocation;
use App\Entity\Location;
use App\Entity\Option;
use App\Entity\Pack;
use App\Entity\Payment;
use App\Entity\Status;
use App\Entity\User;
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
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CarCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Autorent');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-tachometer-alt');
        yield MenuItem::linkToCrud('Véhicules', 'fas fa-car', Car::class);
        yield MenuItem::linkToCrud('Ville de départ', 'fas fa-map-marker-alt', CityPickupLocation::class);
        yield MenuItem::linkToCrud('Ville de retour', 'fas fa-map-marker-alt', CityDropoffLocation::class);
        yield MenuItem::linkToCrud('Locations', 'fas fa-book', Location::class);
        yield MenuItem::linkToCrud('Options', 'fas fa-cogs', Option::class);
        yield MenuItem::linkToCrud('Packs', 'fas fa-box', Pack::class);
        yield MenuItem::linkToCrud('Paiement', 'fas fa-credit-card', Payment::class);
        yield MenuItem::linkToCrud('Statuts', 'fas fa-info-circle', Status::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
        
    }
}
