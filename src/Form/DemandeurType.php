<?php

namespace App\Form;

use App\Entity\Demandeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class DemandeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Nom de famille'
                )))
            ->add('firstname', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Prénom'
                )))
            ->add('email', EmailType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Email'
                )))
            ->add('phone_number', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Numéro de téléphone'
                )))
            ->add('company', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Entreprise'
                )));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demandeur::class,
        ]);
    }
}
