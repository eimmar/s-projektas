<?php

namespace App\Form;

use App\Entity\Model;
use App\Entity\User;
use App\Entity\Vehicle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
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

    /**
     * @var int
     */
    private $maxUserVehicleCount;

    public function __construct(TokenStorageInterface $tokenStorage, $maxUserVehicleCount)
    {
        $this->tokenStorage = $tokenStorage;
        $this->maxUserVehicleCount = $maxUserVehicleCount;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('powerKw')
            ->add('engineCapacity')
            ->add('yearMade')
            ->add('monthMade')

            ->add('model', EntityType::class,
                [
                    'class' => Model::class,
//                    'label' => 'address.city',
//                    'empty_data' => 'address.please_select',
//                    'query_builder' => function (ModelRepository $er) us) {
//                        return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
//                    },
                    'group_by' => function(Model $value, $key, $index) {
                        return $value->getManufacturer()->getName();
                    }
                ])
            ->add('transmissionType')
            ->add('fuelType');

        $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'preSubmit']);

        //TODO: Add manufacturer field to filter out models
//        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'preSetData']);
//        $builder->get('manufacturer')->addEventListener(FormEvents::POST_SUBMIT, [$this, 'postSubmitManufacturer']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user && $user->getVehicles()->count() >= $this->maxUserVehicleCount) {
            $event->getForm()
                ->addError(
                    new FormError(sprintf('vehicle.form.max_vehicle_error %s', $this->maxUserVehicleCount))
                );
        }
    }

//    /**
//     * @param FormEvent $event
//     */
//    public function preSetData(FormEvent $event)
//    {
//        $this->getModelSelections($event->getForm(), $event->getData()->getManufacturer());
//    }
//
//    /**
//     * @param FormEvent $event
//     */
//    public function postSubmitManufacturer(FormEvent $event)
//    {
//        $form = $event->getForm();
//        $this->getModelSelections($form->getParent(), $form->getData());
//    }
//
//    /**
//     * @param FormInterface $form
//     * @param Manufacturer|null $manufacturer
//     */
//    private function getModelSelections(FormInterface $form, Manufacturer $manufacturer = null)
//    {
//        $models = $manufacturer ? $manufacturer->getModels() : [];
//        $form->add('model', EntityType::class, [
//           'class' => 'App\Entity\Model',
//            'placeholder' => '',
//            'choices' => $models,
//        ]);
//    }
}
