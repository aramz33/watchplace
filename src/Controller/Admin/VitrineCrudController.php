<?php

namespace App\Controller\Admin;

use App\Entity\Vitrine;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VitrineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vitrine::class;
        }

    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('creator'),
            BooleanField::new('published')
                ->onlyOnForms()
                ->hideWhenCreating(),
            TextField::new('description'),

            AssociationField::new('montres')
                ->onlyOnForms()
                // on ne souhaite pas gérer l'association entre les
                // montres et la remontoires dès la création de la
                // vitrine
                ->hideWhenCreating()
                ->setTemplatePath('admin/fields/remontoire_montres.html.twig')
                // Ajout possible seulement pour des montres qui
                // appartiennent au même propriétaire du remontoire
                // que le creator de la vitrine
                ->setQueryBuilder(
                    function (QueryBuilder $queryBuilder) {
                        // récupération de l'instance courante de la vitrine
                        $currentVitrine = $this->getContext()->getEntity()->getInstance();
                        $creator = $currentVitrine->getCreator();
                        $memberId = $creator->getId();
                        // charge les seuls montres dont le 'owner' du remontoire est le creator de la vitrine
                        $queryBuilder->leftJoin('entity.remontoire_id', 'i')
                            ->leftJoin('i.member', 'm')
                            ->andWhere('m.id = :member_id')
                            ->setParameter('member_id', $memberId);
                        return $queryBuilder;
                    }
                ),
        ];
    }
}


