<?php

namespace App\Form;

use App\Entity\Obj;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Nom du Webinaire'
                )))
            ->add('photo_link', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Lien de la photo'
                )))
            ->add('video_link', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Lien de la vidéo'
                )))
            ->add('summarize', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Résumer du Webinaire'
                )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Obj::class,
        ]);
    }
}
