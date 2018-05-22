<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Vehicle;
use App\Entity\Visit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class VisitType extends AbstractType
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Router
     */
    private $router;

    /**
     * VisitType constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param Router $router
     */
    public function __construct(TokenStorageInterface $tokenStorage, Router $router)
    {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($this->router->generate('visit_update'))
            ->add('visitDate')
            ->add('vehicle', EntityType::class, [
                'class'   => Vehicle::class,
                'choices' => $this->user->getVehicles()
            ])
            ->add('visitServices', CollectionType::class, [
                'entry_type'    => VisitServiceType::class,
                'allow_delete'  => true,
                'allow_add'     => true,
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
