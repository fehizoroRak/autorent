<?php

namespace App\Controller\Admin;

use App\Entity\CityDropoffLocation;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RequestStack;

class CityDropoffLocationCrudController extends AbstractCrudController
{
    private $entityManager;
    private $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public static function getEntityFqcn(): string
    {
        return CityDropoffLocation::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addCssFile('assets/css/admin.css');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Ville de retour')
            ->setEntityLabelInPlural('Villes de retour')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Villes de retour')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter une Ville de retour')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier une Ville de retour')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails de la Ville de retour')
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
                fn (Action $action) => $action->setLabel('Ajouter Ville de retour')->setCssClass('btn btn-success actions-buttons'))
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
            IdField::new('id')->hideWhenCreating()->hideWhenUpdating(),
            TextField::new('name', 'Nom de la Ville'),
        ];
    }
}
