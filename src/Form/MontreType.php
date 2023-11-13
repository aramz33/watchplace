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

class MontreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);
        $montre = $options['data'] ?? null;
        $remontoire = $montre->getRemontoireId();

        $builder
            ->add('brand')
            ->add('remontoire_id', null, [
                'disabled'   => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Montre::class,
        ]);
    }
}
