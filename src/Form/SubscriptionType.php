<?php

namespace App\Form;

use App\DTO\SubscriptionDTO;
use App\Form\ContactType;
use App\Form\ProductType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contact', ContactType::class)
            ->add('product', ProductType::class)
            ->add('beginDate', TextType::class)
            ->add('endDate', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubscriptionDTO::class,
            'csrf_protection' => false,
        ]);
    }
}
