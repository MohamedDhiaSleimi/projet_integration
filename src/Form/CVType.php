<?php

namespace App\Form;

use App\Entity\CV;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('skills', TextType::class, [
                'label' => 'Skills'
            ])
            ->add('education', TextType::class, [
                'label' => 'Education'
            ])
            ->add('experience', TextType::class, [
                'label' => 'Experience',
                'required' => false
            ])
            ->add('languages', TextType::class, [
                'label' => 'Languages',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CV::class,
        ]);
    }
} 