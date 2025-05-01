<?php
// src/Form/SupervisorType.php
namespace App\Form;

use App\Entity\Supervisor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class SuppervisorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [new NotBlank()],
                'label' => 'Full Name',
                'attr' => ['placeholder' => 'Enter supervisor full name']
            ])
            ->add('email', EmailType::class, [
                'constraints' => [new NotBlank(), new Email()],
                'label' => 'Email Address',
                'attr' => ['placeholder' => 'Enter supervisor email address']
            ])
            ->add('department', TextType::class, [
                'required' => false,
                'label' => 'Department',
                'attr' => ['placeholder' => 'Enter supervisor department']
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => false,
                'label' => 'Phone Number',
                'attr' => ['placeholder' => 'Enter supervisor phone number']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Supervisor::class,
        ]);
    }
}