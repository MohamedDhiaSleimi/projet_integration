<?php

namespace App\Form;

use App\Entity\SeanceEncadrement;
use App\Entity\Student;
use App\Entity\Supervisor;
use App\Repository\StudentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceEncadrementType extends AbstractType
 {
    private Security $security;

    public function __construct( Security $security )
 {
        $this->security = $security;
    }

    public function buildForm( FormBuilderInterface $builder, array $options ): void
 {
        $user = $this->security->getUser();
        $isAdmin = in_array( 'ROLE_ADMIN', $user->getRoles(), true );
        $isSupervisor = in_array( 'ROLE_SUPERVISOR', $user->getRoles(), true );

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
        ] );

        if ( $isAdmin ) {
            $builder
            ->add( 'student', EntityType::class, [
                'class' => Student::class,
                'choice_label' => fn( Student $s ) => $s->getName(),
                'label' => 'Student',
                'attr' => [ 'class' => 'form-control' ],
                'placeholder' => 'Choose a student'
            ] )
            ->add( 'supervisor', EntityType::class, [
                'class' => Supervisor::class,
                'choice_label' => fn( Supervisor $s ) => $s->getName(),
                'label' => 'Supervisor',
                'attr' => [ 'class' => 'form-control' ],
                'placeholder' => 'Choose a supervisor'
            ] );
        }

        if ( $isSupervisor && $user instanceof Supervisor ) {
            $builder
            ->add( 'student', EntityType::class, [
                'class' => Student::class,
                'choice_label' => fn( Student $s ) => $s->getName(),
                'label' => 'Student',
                'query_builder' => function ( StudentRepository $repo ) use ( $user ) {
                    return $repo->createQueryBuilder( 's' )
                    ->join( 's.applications', 'a' )
                    ->where( 'a.supervisor = :supervisor' )
                    ->setParameter( 'supervisor', $user )
                    ->groupBy( 's.id' );
                }
                ,
                'attr' => [ 'class' => 'form-control' ],
                'placeholder' => 'Choose a student'
            ] )
            ->add( 'supervisor', EntityType::class, [
                'class' => Supervisor::class,
                'choices' => [ $user ],     // only one choice: the current supervisor
                'data' => $user,
                'label' => false,
                'mapped' => true,
                'choice_label' => fn( Supervisor $s ) => $s->getName(),
                'attr' => [ 'hidden' => 'hidden' ],  // hide this field ( it will submit the data )
            ] )
            ->add( 'supervisorName', EntityType::class, [
                'class' => Supervisor::class,
                'choices' => [ $user ],    // same single choice
                'data' => $user,
                'label' => 'Supervisor',
                'mapped' => false,
                'disabled' => true,      // disables the dropdown ( read-only )
                'choice_label' => fn( Supervisor $s ) => $s->getName(),
                'attr' => [ 'class' => 'form-control' ],
            ] );
        }

        $builder->add( 'save', SubmitType::class, [
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
