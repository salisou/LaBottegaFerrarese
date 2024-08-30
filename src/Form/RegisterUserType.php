<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'placeholder' => 'Inserisci il tuo indirizzo e-mail'
                ]
            ])

            // ->add('roles')
            // ->add('password', PasswordType::class, [
            //     'label' => 'Password',
            //     'attr' => [
            //         'placeholder' => 'Inserisci la tua password'
            //     ]
            // ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'max' => 30
                    ])
                ],
                'first_options'  => [
                    'label' => 'Password',
                    'hash_property_path' => 'password',
                    'attr' => [
                        'placeholder' => 'Inserisci la tua password'
                    ]
                ],
                'second_options' => [
                    'label' => 'Conferma password',
                    'attr' => [
                        'placeholder' => 'Conferma la tua password'
                    ]
                ],
                'mapped' => false

            ])

            ->add('first_name', TextType::class, [
                'label' => 'Nome',
                'attr' => [
                    'placeholder' => 'Entra il tuo nome'
                ]
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Cognome',
                'attr' => [
                    'placeholder' => 'Entra il tuo cognome'
                ]
            ])
            ->add('salva', SubmitType::class, [
                'label' => 'Salva',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new UniqueEntity([
                    'entityClass' => User::class,
                    'fields' => 'email'

                ])
            ],
            'data_class' => User::class,
        ]);
    }
}
