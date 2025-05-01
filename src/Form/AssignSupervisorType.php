<?php
// src/Form/AssignSupervisorType.php
namespace App\Form;

use App\Entity\Application;
use App\Entity\Supervisor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AssignSupervisorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('supervisor', EntityType::class, [
                'class' => Supervisor::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a supervisor',
                'constraints' => [new NotBlank()],
                'label' => 'Assign Supervisor'
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Internship Start Date',
                'constraints' => [new NotBlank()]
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Internship End Date',
                'constraints' => [new NotBlank()]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}