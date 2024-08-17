<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateField::new('startdate', 'Start Date'),
            DateField::new('enddate', 'End Date'),
            DateTimeField::new('starttime', 'Start Time')->setFormat('HH:mm'),
            DateTimeField::new('endtime', 'End Time')->setFormat('HH:mm'),
            NumberField::new('numberOfDays', 'Number of Days')->hideOnForm(),
            NumberField::new('totalamount', 'Total Amount'),
            NumberField::new('packTotalPrice', 'Pack Total Price'),
            NumberField::new('optionsTotalPrice', 'Options Total Price'),
            NumberField::new('totalPerDay', 'Total Per Day'),
            BooleanField::new('isPaid', 'Paid'),
            TextField::new('paymentMethod', 'Payment Method'),
            TextField::new('rentalNumber', 'Rental Number'),
            AssociationField::new('user', 'User'),
            AssociationField::new('car', 'Car'),
            AssociationField::new('pickupLocation', 'Pickup Location'),
            AssociationField::new('dropoffLocation', 'Dropoff Location'),
            AssociationField::new('pack', 'Pack'),
            AssociationField::new('options', 'Options'),
            AssociationField::new('statuses', 'Statuses') // This is the important line to manage the statuses
                ->setFormTypeOption('by_reference', false) // Necessary for Many-to-Many relationships
                ->autocomplete() // Optional, adds a search feature
                ->setRequired(true), // Optional, make this field required
            AssociationField::new('payments', 'Payments'),
        ];
    }
}
