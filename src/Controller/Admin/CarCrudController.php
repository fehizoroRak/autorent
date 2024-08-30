<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class CarCrudController extends AbstractCrudController
{
    private $entityManager;
    private $requestStack;
    private $adminUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, AdminUrlGenerator $adminUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Car::class;
    }
    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addCssFile('assets/css/admin.css');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Véhicule')
            ->setEntityLabelInPlural('Véhicules')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter Véhicule')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier Véhicule')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Véhicules')
            ->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        $showCarDetail = Action::new('showCarDetail', 'Détails', 'fas fa-eye')
            ->linkToCrudAction('showAction')->addCssClass('bg-details');
            
    
        return $actions
            ->add(Crud::PAGE_INDEX, $showCarDetail)
            ->update(Crud::PAGE_INDEX, Action::EDIT,
                fn (Action $action) => $action->setIcon('fas fa-edit')->setLabel('Modifier')->addCssClass('btn btn-warning'))

                ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE,
                fn (Action $action) => $action->setLabel('Enregistrer et continuer'))
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN,
                fn (Action $action) => $action->setLabel('Enregistrer')->setCssClass('btn btn-success'))
            

            ->update(Crud::PAGE_INDEX, Action::DELETE,
                fn (Action $action) => $action->setIcon('fas fa-trash')
                ->setLabel('Supprimer')
                ->addCssClass('btn btn-danger text-black'))

            ->update(Crud::PAGE_INDEX, Action::NEW,
                fn (Action $action) => $action->setLabel('Ajouter Véhicule')->setCssClass('btn btn-success'))
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER,
                fn (Action $action) => $action->setLabel('Créer et ajouter un autre'))
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN,
                fn (Action $action) => $action->setLabel('Créer')->setCssClass('btn btn-success'));
    }
    

    public function showAction(): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $id = $request->query->get('entityId');
        $car = $this->entityManager->getRepository(Car::class)->find($id);

        $locations = $this->entityManager->getRepository(Location::class)->findBy(['car' => $car]);
        $rentedDays = [];

        foreach ($locations as $location) {
            $start = $location->getStartdate();
            $end = $location->getEnddate();

            $interval = new \DateInterval('P1D');
            $period = new \DatePeriod($start, $interval, $end->modify('+1 day'));

            foreach ($period as $date) {
                $rentedDays[] = $date->format('Y-m-d');
            }
        }

        $months = [];
        $monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June', 
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        foreach ($monthNames as $index => $monthName) {
            $firstDayOfMonth = new \DateTime("first day of $monthName 2024");
            $daysInMonth = (int)$firstDayOfMonth->format('t');

            $days = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = new \DateTime($firstDayOfMonth->format('Y-m') . "-$day");
                $days[] = [
                    'date' => $currentDate->format('Y-m-d'),
                    'day' => $day,
                ];
            }

            $months[] = [
                'name' => $firstDayOfMonth->format('F Y'),
                'days' => $days,
            ];
        }

        return $this->render('admin/car_show.html.twig', [
            'entity' => $car,
            'rentedDays' => $rentedDays,
            'months' => $months,
        ]);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('brand', 'Marque'),
            TextField::new('model', 'Modèle'),
            TextField::new('color', 'Couleur'),
            TextField::new('registration', 'Immatriculation'),
            TextField::new('gearbox', 'Boîte de vitesses'),
            ImageField::new('image', 'Image du Véhicule')
                ->setBasePath('/assets/images')
                ->setUploadDir('public/assets/images')
                ->setHelp('Fournir l\'URL de l\'image du véhicule'),
            BooleanField::new('availability', 'Disponibilité'),
            BooleanField::new('electricStatus', 'Électrique'),
            BooleanField::new('recommendedStatus', 'Recommandé'),
            NumberField::new('dayprice', 'Prix par jour')->setHelp('Entrez le prix de location journalier'),
            IntegerField::new('nbofcardoors', 'Nombre de portes'),
            IntegerField::new('nbofpersons', 'Nombre de personnes'),
            IntegerField::new('horsepower', 'Puissance'),
            IntegerField::new('co2emissions', 'Émissions de CO2'),
            BooleanField::new('airconditionnerStatus', 'Climatisation'),
        ];
    }
}

