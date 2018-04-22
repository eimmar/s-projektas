<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.22
 * Time: 23.18
 */

namespace App\Admin;


use App\Entity\Service;
use App\Entity\ServiceType;
use App\Repository\ServiceTypeRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ServiceAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name', TextType::class, ['label' => 'service.form.name'])
            ->add('description', TextareaType::class, ['required' => false, 'label' => 'service.form.description'])
            ->add('priceFrom', MoneyType::class, ['label' => 'service.form.price_from'])
            ->add('priceTo', MoneyType::class, ['label' => 'service.form.price_to'])
            ->add('durationFrom', IntegerType::class, ['label' => 'service.form.duration_from'])
            ->add('durationTo', IntegerType::class, ['label' => 'service.form.duration_to'])
            ->add('serviceType', EntityType::class,
                [
                    'class'         => ServiceType::class,
                    'label'         => 'service.form.service_type',
                    'empty_data'    => 'service.form.please_select',
                    'query_builder' => function (ServiceTypeRepository $er) {
                        return $er->createQueryBuilder('st')->orderBy('st.name', 'ASC');
                    },
                ]
            )
            ->add('isActive', CheckboxType::class, ['required' => false, 'label' => 'service.form.is_active']);

        $form->getFormBuilder()->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'preSubmit']);
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('id')
            ->add('name')
            ->add('priceFrom')
            ->add('priceTo')
            ->add('durationFrom')
            ->add('durationTo')
            ->add('serviceType')
            ->add('isActive');
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('priceFrom')
            ->addIdentifier('priceTo')
            ->addIdentifier('durationFrom')
            ->addIdentifier('durationTo')
            ->addIdentifier('serviceType')
            ->addIdentifier('isActive');
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        //TODO: Implement a more convenient way of entering service duration from/to
    }

    /**
     * @param Service $service
     */
    public function prePersist($service)
    {
        $service->prePersist();
        $service->setUserCreatedBy(
            $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser()
        );
    }
}
