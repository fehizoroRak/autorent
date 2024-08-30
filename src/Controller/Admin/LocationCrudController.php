<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addCssFile('assets/css/admin.css');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Location')
            ->setEntityLabelInPlural('Locations')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Locations')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter une Location')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier une Location')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails de la Location')
            ->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL,
                fn (Action $action) => $action->setIcon('fas fa-eye')->setLabel('Détails')->addCssClass('bg-details'))
            ->update(Crud::PAGE_INDEX, Action::EDIT,
                fn (Action $action) => $action->setIcon('fas fa-edit')->setLabel('Modifier')->addCssClass('btn btn-warning'))
            ->update(Crud::PAGE_INDEX, Action::DELETE,
                fn (Action $action) => $action->setIcon('fas fa-trash')
                ->setLabel('Supprimer')
                ->addCssClass('btn btn-danger text-black'))
            ->update(Crud::PAGE_INDEX, Action::NEW,
                fn (Action $action) => $action->setLabel('Ajouter une Location')->setCssClass('btn btn-success actions-buttons'))
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER,
                fn (Action $action) => $action->setLabel('Créer et ajouter un autre'))
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN,
                fn (Action $action) => $action->setLabel('Créer')->setCssClass('btn btn-success actions-buttons'))
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE,
                fn (Action $action) => $action->setLabel('Enregistrer et continuer'))
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN,
                fn (Action $action) => $action->setLabel('Enregistrer')->setCssClass('btn btn-success actions-buttons'))
            ->update(Crud::PAGE_DETAIL, Action::DELETE,
                fn (Action $action) => $action->setLabel('Supprimer')->setCssClass('btn btn-danger text-black'))
            ->update(Crud::PAGE_DETAIL, Action::EDIT,
                fn (Action $action) => $action->setLabel('Modifier')->setCssClass('btn btn-warning'))
            ->update(Crud::PAGE_DETAIL, Action::INDEX,
                fn (Action $action) => $action->setLabel('Retour à la liste')->setCssClass('btn btn-success actions-buttons'));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('rentalNumber', 'N° location'),
            AssociationField::new('user', 'Utilisateur'),
            AssociationField::new('car', 'Véhicule'),
            ImageField::new('car.image', 'Image')
            ->setBasePath('/assets/images')
            ->setUploadDir('public/assets/images')
            ->setRequired(false)
            ->onlyOnIndex(),
            DateField::new('startdate', 'Date début'),
            DateField::new('enddate', 'Date fin'),
            DateTimeField::new('starttime', 'Heure début')->setFormat('HH:mm'),
            DateTimeField::new('endtime', 'Heure fin')->setFormat('HH:mm'),
            AssociationField::new('pickupLocation', 'Lieu départ'),
            AssociationField::new('dropoffLocation', 'Lieu retour'),
            NumberField::new('numberOfDays', 'Nbr de jours')->hideOnForm(),
            NumberField::new('totalamount', 'Montant total'),
            NumberField::new('packTotalPrice', 'Prix total pack'),
            NumberField::new('optionsTotalPrice', 'Prix total options'),
            NumberField::new('totalPerDay', 'Total/jour'),
            BooleanField::new('isPaid', 'Payé'),
            TextField::new('paymentMethod', 'Méthode de paiement'),
            AssociationField::new('pack', 'Pack'),
            AssociationField::new('options', 'Options'),
            AssociationField::new('statuses', 'Statuts')
            ->formatValue(function ($value) {
                // Assuming $value is a collection of Status entities
                return implode(', ', array_map(fn($status) => $status->getName(), $value->toArray()));
            }),
            AssociationField::new('payments', 'Paiements')
            ->formatValue(function ($value, $entity) {
                $payments = $entity->getPayments();
                if ($payments->isEmpty()) {
                    return '<span style="color:red; font-weight: bold;">ø paiement</span>';
                }

                $paymentMethods = array_map(function ($payment) {
                    return $payment->getPaymentmode(); // Assuming the payment entity has a getMethod() method
                }, $payments->toArray());

                return implode(', ', $paymentMethods);
            })
            ->onlyOnIndex()
       
        ];
    }
}
