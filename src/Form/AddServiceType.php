<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.5.17
 * Time: 19.19
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Router;

class AddServiceType extends AbstractType
{
    const FIELD_SERVICE = 'service';

    /**
     * @var Router
     */
    private $router;

    /**
     * AddServiceType constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($this->router->generate('visit_arrange'))
            ->add(self::FIELD_SERVICE, HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}
