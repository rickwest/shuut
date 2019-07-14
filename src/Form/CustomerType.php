<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('accountRef', TextType::class, [
                'label' => 'Account Ref',
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
            ])
            ->add('contactName', TextType::class, [
                'required' => false,
                'label' => 'Contact Name',
            ])
            ->add('telephone', TelType::class)
            ->add('email', EmailType::class)
            ->add('address', AddressType::class, [
                'label' => false,
            ])
            ->add('accountsContactName', TextType::class, [
                'required' => false,
                'label' => 'Name',
            ])
            ->add('accountsTelephone', TelType::class, [
                'required' => false,
                'label' => 'Telephone',
            ])
            ->add('accountsEmail', EmailType::class, [
                'required' => false,
                'label' => 'Email',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
