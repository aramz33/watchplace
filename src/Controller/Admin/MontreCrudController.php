<?php

namespace App\Controller\Admin;

use App\Entity\Montre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MontreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Montre::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            TextField::new('brand'),
            AssociationField::new('remontoire_id'),
        ];
    }

}
