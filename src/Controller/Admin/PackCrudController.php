<?php

namespace App\Controller\Admin;

use App\Entity\Pack;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pack::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Name'),
            NumberField::new('pricePerDay', 'Price Per Day'),
            NumberField::new('franchise', 'Franchise')->hideOnIndex(),
            TextareaField::new('content1', 'Content 1')->hideOnIndex(),
            TextareaField::new('content2', 'Content 2')->hideOnIndex(),
            TextareaField::new('content3', 'Content 3')->hideOnIndex(),
            TextareaField::new('content4', 'Content 4')->hideOnIndex(),
            TextareaField::new('content5', 'Content 5')->hideOnIndex(),
        ];
    }
}
