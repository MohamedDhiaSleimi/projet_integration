<?php
namespace App\Form;

use App\Entity\SeanceEncadrement;
use App\Entity\Student;
use App\Entity\Supervisor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceEncadrementType extends AbstractType
 {
    public function buildForm( FormBuilderInterface $builder, array $options ): void
 {
        $builder
        ->add( 'date', DateTimeType::class, [
            'widget' => 'single_text',
            'label' => 'Session Date',
            'attr' => [ 'class' => 'form-control' ]
        ] )
        ->add( 'commentaire', TextareaType::class, [
            'label' => 'Comments',
            'attr' => [
                'class' => 'form-control',
                'rows' => 5,
                'placeholder' => 'Enter your comments about the session...'
            ]
        ] )
        ->add( 'Student', EntityType::class, [
            'class' => Student::class,
            'choice_label' => function ( Student $student ) {
                return $student->getName();
            }
            ,
            'label' => 'Student',
            'attr' => [ 'class' => 'form-control' ],
            'placeholder' => 'Choose a student'
        ] )
        ->add( 'Supervisor', EntityType::class, [
            'class' => Supervisor::class,
            'choice_label' => function ( Supervisor $supervisor ) {
                return $supervisor->getName();
            }
            ,
            'label' => 'Supervisor',
            'attr' => [ 'class' => 'form-control' ],
            'placeholder' => 'Choose a supervisor'
        ] )
        ->add( 'save', SubmitType::class, [
            'label' => 'Save',
            'attr' => [ 'class' => 'btn btn-primary' ]
        ] );
    }

    public function configureOptions( OptionsResolver $resolver ): void
 {
        $resolver->setDefaults( [
            'data_class' => SeanceEncadrement::class,
        ] );
    }
}