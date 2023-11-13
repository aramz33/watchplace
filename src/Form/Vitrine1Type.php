<?php

namespace App\Form;

use App\Entity\Montre;
use App\Entity\Vitrine;
use App\Repository\MontreRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Vitrine1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        //dump($options);
        $vitrine = $options['data'] ?? null;
        $member = $vitrine->getCreator();

        $builder
            ->add('description')
            ->add('published')
            ->add('creator', null, [
                'disabled'   => true,
            ])
            ->add('montres', null, [
                'by_reference' => false,
                // classe pas obligatoire
                'class' => Montre::class,
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


                ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vitrine::class,
        ]);
    }
}
