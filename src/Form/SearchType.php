<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.24
 * Time: 22.31
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SearchType as SearchTypeField;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    const GLOBAL_SEARCH_NAME = 'search';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(self::GLOBAL_SEARCH_NAME, SearchTypeField::class,
            [
                'label'     => 'service.form.search',
                'required'  => false
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
