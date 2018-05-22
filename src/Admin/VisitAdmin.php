<?php
namespace App\Admin;

use App\Entity\User;
use App\Entity\VisitService;
use App\Entity\VisitStatus;
use App\Form\AddressType;
use App\Form\VisitServiceType;
use Doctrine\ORM\Query\Expr\Select;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.21
 * Time: 20.13
 */

class VisitAdmin extends AbstractAdmin
{
    /**
     * @return array
     */
    private function getArray($data)
    {
        return array_reduce($data, function($res, VisitStatus $x){
            $res[$x->getName()] = $x;
            return $res;
        }, []);
    }
    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $repository = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager()->getRepository(VisitStatus::class);
        $all = $repository->findAll();


        $form->add('vehicle', TextType::class, ['disabled' => true, 'required' => false])
            ->add('status', EntityType::class, ['choices' => $all, 'class' => VisitStatus::class])
            ->add('visitDate', DateType::class)
            ->add('dateCreated', DateType::class, ['disabled' => true, 'required' => false])
            ->add('dateUpdated', DateType::class, ['disabled' => true, 'required' => false])
            ->add('visitServices', CollectionType::class,
            [
                'allow_add'     => true,
                'allow_delete'  => true,
                'required'      => false,
                'prototype'     => true,
                'entry_type'    => VisitServiceType::class,
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
