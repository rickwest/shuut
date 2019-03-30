<?php

namespace App\Form;

use App\Entity\Vehicle;
use App\Entity\VehicleType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registration', TextType::class, [])
            ->add('make', TextType::class, [])
            ->add('model', TextType::class, [])
            ->add('vehicleType', EntityType::class, [
                'class' => VehicleType::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose an option...',
            ])
            ->add('width', NumberType::class, [
                'required' => false,
            ])
            ->add('depth', NumberType::class, [
                'required' => false,
            ])
            ->add('height', NumberType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
