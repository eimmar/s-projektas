<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class VehicleType extends AbstractType
{

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('powerKw')
            ->add('engineCapacity')
            ->add('yearMade')
            ->add('monthMade')
            ->add('model')
            ->add('transmissionType')
            ->add('fuelType')

            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'setCurrentUser'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }

    public function setCurrentUser(FormEvent $event)
    {
        /** @var Vehicle $data */
        $data = $event->getData();
        $data->setUser($this->tokenStorage->getToken()->getUser());
    }
}
