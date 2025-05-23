<?php
// src/Form/SupervisorType.php
namespace App\Form;

use App\Entity\Supervisor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class SuppervisorType extends AbstractType
 {
    public function buildForm( FormBuilderInterface $builder, array $options ): void
 {
        $builder
        ->add( 'name', TextType::class, [
            'constraints' => [ new NotBlank() ],
            'label' => 'Full Name',
            'attr' => [ 'placeholder' => 'Enter supervisor full name' ]
        ] )
        ->add( 'email', EmailType::class, [
            'constraints' => [ new NotBlank(), new Email() ],
            'label' => 'Email Address',
            'attr' => [ 'placeholder' => 'Enter supervisor email address' ]
        ] )
        ->add( 'password', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'Password',
                'attr' => [ 'placeholder' => 'Enter password' ]
            ],
            'second_options' => [
                'label' => 'Confirm Password',
                'attr' => [ 'placeholder' => 'Repeat password' ]
            ],
            'invalid_message' => 'The password fields must match.',
            'required' => true,
            'constraints' => [ new NotBlank() ],
        ] )
        ->add( 'department', TextType::class, [
            'required' => false,
            'label' => 'Department',
            'attr' => [ 'placeholder' => 'Enter supervisor department' ]
        ] )
        ->add( 'phoneNumber', TextType::class, [
            'required' => false,
            'label' => 'Phone Number',
            'attr' => [ 'placeholder' => 'Enter supervisor phone number' ]
        ] )
        ->add( 'roles', HiddenType::class, [
            'data' => json_encode( [ 'ROLE_SUPERVISOR' ] ),
            'mapped' => false, // we set it manually in the controller
        ] );
    }

    public function configureOptions( OptionsResolver $resolver ): void
 {
        $resolver->setDefaults( [
            'data_class' => Supervisor::class,
        ] );
    }
}
