<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Quote;
use App\Entity\VehicleType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteStep1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose an option...',
            ])
            ->add('vehicleType', EntityType::class, [
                'class' => VehicleType::class,
                'choice_label' => 'name',
                'label' => 'Vehicle Type',
                'placeholder' => 'Choose an option...',
            ])
            ->add('pickUp', AddressType::class)
            ->add('dropOff', AddressType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }
}
