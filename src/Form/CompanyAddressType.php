<?php

namespace App\Form;


use App\Entity\CompanyAddress;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyAddressType extends AddressType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompanyAddress::class,
        ]);
    }
}
