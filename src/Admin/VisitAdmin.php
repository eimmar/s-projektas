<?php
namespace App\Admin;

use App\Entity\Visit;
use App\Entity\VisitStatus;
use App\Form\VisitServiceAdminType;
use App\Repository\VisitStatusRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class VisitAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('vehicle')
            ->add('status', EntityType::class,
                [
                    'class' => VisitStatus::class,
                    'query_builder' => function (VisitStatusRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->where('s.name != :name')
                            ->setParameter('name', Visit::STATUS_NOT_SUBMITTED);
                    },
                ]
            )
            ->add('visitDate', DateType::class, ['required' => true])
            ->add('dateCreated', DateType::class, ['disabled' => true, 'required' => false])
            ->add('dateUpdated', DateType::class, ['disabled' => true, 'required' => false])
            ->add('visitServices', CollectionType::class,
                [
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'prototype'     => true,
                    'entry_type'    => VisitServiceAdminType::class,
                    'by_reference' => false
                ]);

    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('id');
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id')
            ->addIdentifier('vehicle')
            ->addIdentifier('status')
            ->addIdentifier('visitDate')
            ->addIdentifier('dateCreated')
            ->addIdentifier('dateUpdated');
    }
}
