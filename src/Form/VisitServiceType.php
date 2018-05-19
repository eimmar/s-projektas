<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.5.17
 * Time: 22.59
 */

namespace App\Form;


use App\Entity\VisitService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', HiddenType::class)
            ->add('description', HiddenType::class)
            ->add('duration', HiddenType::class)
            ->add('price', HiddenType::class)
            ->add('quantity', HiddenType::class)
            ->add('visit', HiddenType::class, ['property_path' => 'id'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VisitService::class,
        ]);
    }
}