<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Nom',
                'constraints' =>  new Length([
                    'min' => 2,
                    'max' => 30,
                ]),
                'attr' => [
                    'placeholder' => 'Votre Nom',
                    'class' => 'form-control',
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Prénom',
                'constraints' =>  new Length([
                    'min' => 2,
                    'max' => 30,
                ]),
                'attr' => [
                    'placeholder' => 'Votre Prénom',
                    'class' => 'form-control',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' =>  new Length([
                    'min' => 2,
                    'max' => 60,
                ]),
                'attr' => [
                    'placeholder' => 'Votre Email',
                    'class' => 'form-control',
                ],
            ])
            // ->add('roles')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre',
                'required' => true,
                'label' => 'Mot de passe',
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Votre mot de passe',
                        'class' => 'form-control',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmation du mot de passe',
                        'class' => 'form-control',
                    ],
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'btn btn-primary btn-block mt-3',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
