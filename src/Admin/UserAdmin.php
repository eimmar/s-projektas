<?php
namespace App\Admin;

use App\Form\AddressType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.21
 * Time: 20.13
 */

class UserAdmin extends AbstractAdmin
{

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('email', TextType::class)
            ->add('username', TextType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('enabled', CheckboxType::class, ['required' => false])
            ->add('addresses', CollectionType::class,
                [
                    'entry_type'    => AddressType::class,
                    'label'         => 'profile.show.addresses',
                    'entry_options' => ['label' => 'profile.show.address'],
                    'required'      => false,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'prototype'     => true,
                    'attr'          => ['class' => 'address-type'],
                    'by_reference' => false
                ]);
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('email')
            ->add('username')
            ->add('firstName')
            ->add('lastName')
            ->add('enabled');
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('email', TextType::class)
            ->addIdentifier('username', TextType::class)
            ->addIdentifier('firstName', TextType::class)
            ->addIdentifier('lastName', TextType::class)
            ->addIdentifier('enabled');
    }
}
