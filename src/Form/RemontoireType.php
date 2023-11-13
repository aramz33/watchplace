<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\Montre;
use App\Entity\Remontoire;
use App\Repository\MontreRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemontoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);
        $remontoire = $options['data'] ?? null;
        $member = $remontoire->getMember();

        $builder
            ->add('nom')
            ->add('montres', null, [
                'by_reference' => false,
                // classe pas obligatoire
                //'class' => [Object]::class,
                // permet sélection multiple
                'multiple' => true,
                // affiche sous forme de checkboxes
                'expanded' => true,
                'query_builder' => function (MontreRepository $er) use ($member) {
                    return $er->createQueryBuilder('o')
                        ->leftJoin('o.remontoire_id', 'i')
                        ->andWhere('i.member = :member')
                        ->setParameter('member', $member)
                        ;
                }
            ])
            ->add('member', null, [
                'disabled'   => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Remontoire::class,
        ]);
    }
}
