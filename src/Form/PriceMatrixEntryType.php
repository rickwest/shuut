<?php

namespace App\Form;

use App\Entity\PriceMatrixEntry;
use App\Entity\VehicleType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceMatrixEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vehicleType', EntityType::class, [
                'class' => VehicleType::class,
                'choice_label' => 'name',
                'label' => 'Vehicle Type',
                'placeholder' => 'Choose an option...',
            ])
            ->add('costPrice', MoneyType::class, [
                'currency' => 'GBP',
            ])
            ->add('salePrice', MoneyType::class, [
                'currency' => 'GBP',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PriceMatrixEntry::class,
        ]);
    }
}
