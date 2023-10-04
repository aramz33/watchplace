<?php

namespace App\Controller\Admin;

use App\Entity\Remontoire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class RemontoireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Remontoire::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            //TextField::new(''),
            AssociationField::new('montres'),
        ];
    }

}
