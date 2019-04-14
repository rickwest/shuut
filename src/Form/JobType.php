<?php

namespace App\Form;

use App\Entity\Driver;
use App\Entity\Job;
use App\Entity\Vehicle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vehicle', EntityType::class, [
                'class' => Vehicle::class,
                'choice_label' => 'registration',
                'placeholder' => 'Assign a vehicle...',
                'required' => false,
            ])
            ->add('driver', EntityType::class, [
                'class' => Driver::class,
                'choice_label' => 'name',
                'placeholder' => 'Assign a driver...',
                'required' => false,
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
