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
use Symfony\Component\Validator\Constraints\Length;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', TextType::class,
                [
                    'label' => 'address.street',
                    'required' => false,
                    'constraints' => [new Length(['max' => 255])]
                ])
            ->add('comment', TextType::class,
                [
                    'label' => 'address.comment',
                    'required' => false,
                    'constraints' => [new Length(['max' => 255])]
                ])
            ->add('city', EntityType::class,
                [
                    'class' => City::class,
                    'label' => 'address.city',
                    'required' => true,
                    'query_builder' => function (CityRepository $er) {
                        return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                    },
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
