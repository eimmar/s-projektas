<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.28
 * Time: 21.40
 */

namespace App\Admin;


use App\Entity\Config;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ConfigAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name', TextType::class, ['label' => 'config.form.name'])
            ->add('value', TextType::class, ['label' => 'config.form.value', 'required' => false])
            ->add('description', TextareaType::class, ['required' => false, 'label' => 'config.form.description']);

        if ($this->getRequest()->get('_route') === 'admin_app_config_edit') {
            $form->add('userChangedBy', EntityType::class,
                [
                    'disabled'  => true,
                    'label'     => 'config.form.user_changed_by',
                    'class'     => User::class,
                ]
            );
        }
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('id')
            ->add('name')
            ->add('value')
            ->add('dateCreated')
            ->add('dateUpdated')
            ->add('userChangedBy');
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('value')
            ->addIdentifier('dateCreated')
            ->addIdentifier('dateUpdated')
            ->addIdentifier('userChangedBy');
    }

    /**
     * @param Config $config
     */
    public function prePersist($config)
    {
        $config->setUserChangedBy(
            $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser()
        );
    }

    /**
     * @param Config $config
     */
    public function preUpdate($config)
    {
        $config->setUserChangedBy(
            $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser()
        );
    }
}
