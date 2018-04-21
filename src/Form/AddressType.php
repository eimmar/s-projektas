<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\City;
use App\Repository\CityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', TextType::class,
                [
                    'label' => 'address.street',
                ])
            ->add('comment', TextType::class,
                [
                    'label' => 'address.comment',
                ])
            ->add('city', EntityType::class,
                [
                    'class' => City::class,
                    'label' => 'address.city',
                    'empty_data' => 'address.please_select',
                    'query_builder' => function (CityRepository $er) {
                        return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                    },
                    'group_by' => function(City $value, $key, $index) {
                        return $value->getCountry()->getName();
                    }
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
