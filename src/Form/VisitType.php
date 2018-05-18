<?php

namespace App\Form;

use App\Entity\Visit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visitDate')
            ->add('vehicle')
            ->add('visitServices', CollectionType::class, [
                'entry_type'    => VisitServiceType::class,
                'allow_delete'  => true,
                'prototype'     => true,
                'by_reference'  => false,
                'attr'          => ['class' => 'visit-service-type'],
            ])
            ->add('status', HiddenType::class, ['property_path' => 'id'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visit::class,
        ]);
    }
}
