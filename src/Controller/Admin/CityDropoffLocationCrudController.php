<?php

namespace App\Controller\Admin;

use App\Entity\CityDropoffLocation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CityDropoffLocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CityDropoffLocation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Ville de retour')
            ->setEntityLabelInPlural('Villes de retour')
            ->showEntityActionsInlined()
            ->setPageTitle(Crud::PAGE_DETAIL, 'Ville de retour');
    }
    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL); // Ajoute l'action "Voir"
    }

  
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideWhenCreating()->hideWhenUpdating(),
            TextField::new('name'),
    
        ];
    }
    
}
