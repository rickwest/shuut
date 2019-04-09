<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('line1', TextType::class, [
            ])
            ->add('line2', TextType::class, [
                'required' => false,
            ])
            ->add('city', TextType::class, [
            ])
            ->add('county', TextType::class, [
                'required' => false,
            ])
            ->add('postcode', TextType::class, [
            ])
            ->add('country', TextType::class, [
                'required' => false,
            ])
            ->add('lat', HiddenType::class, [
                'validation_groups' => ['']
            ])
            ->add('lon', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
