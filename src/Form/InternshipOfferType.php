<?php
// src/Form/InternshipOfferType.php
namespace App\Form;

use App\Entity\InternshipOffer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InternshipOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Offer Title',
                'attr' => ['placeholder' => 'e.g. Web Developer Intern']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Job Description',
                'attr' => ['rows' => 6]
            ])
            ->add('location', TextType::class, [
                'label' => 'Location',
                'attr' => ['placeholder' => 'e.g. Paris or Remote']
            ])
            ->add('duration', TextType::class, [
                'label' => 'Duration',
                'attr' => ['placeholder' => 'e.g. 3 months']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InternshipOffer::class,
        ]);
    }
}