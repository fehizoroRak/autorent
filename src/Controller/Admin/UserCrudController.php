<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Last Name'),
            TextField::new('firstname', 'First Name'),
            EmailField::new('email', 'Email'),
            TextField::new('phonenumber', 'Phone Number')->hideOnIndex(),
            TextField::new('address', 'Address')->hideOnIndex(),
            TextField::new('password', 'Password')
                ->onlyOnForms()
                ->setFormTypeOption('empty_data', '') // To prevent showing current password
                ->hideWhenUpdating(),
            // ChoiceField for roles to allow selection
            ChoiceField::new('roles', 'Roles')
                ->setChoices([
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ])
                ->allowMultipleChoices(true)
                ->renderExpanded(true),
            AssociationField::new('locations', 'Locations')->hideOnForm(),
        ];
    }
}
