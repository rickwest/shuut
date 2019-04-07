<?php

namespace App\Form;

use App\Entity\LineItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', ChoiceType::class, [
                'placeholder' => 'Choose an option...',
                'choices' => [
                    'Mileage Charge' => 'Mileage Charge',
                    'Toll Charge' => 'Toll Charge',
                    'Other' => 'Other',
                ]
            ])
            ->add('quantity', IntegerType::class, [
                'empty_data' => 1
            ])
            ->add('rate', MoneyType::class, [
                'currency' => 'GBP',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LineItem::class,
        ]);
    }
}
