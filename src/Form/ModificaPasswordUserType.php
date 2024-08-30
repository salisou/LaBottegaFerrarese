<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ModificaPasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPassword', PasswordType::class, [
                'label' => 'Password attuale',
                'attr' => [
                    'placeholder' => 'Inserisci la tua password attuale',
                ],
                'mapped' => false
            ])

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'max' => 30
                    ])
                ],
                'first_options'  => [
                    'label' => 'Nuova Password',
                    'hash_property_path' => 'password',
                    'attr' => [
                        'placeholder' => 'Inserisci la tua nuova password',
                    ]
                ],
                'second_options' => [
                    'label' => 'Conferma Nuova Password',
                    'attr' => [
                        'placeholder' => 'Conferma la tua nuova password',
                    ]
                ],
                'mapped' => false

            ])

            ->add(
                'salva',
                SubmitType::class,
                [
                    'label' => 'Aggiorna la Password',
                    'attr' => [
                        'class' => 'btn btn-success'
                    ]
                ]
            )

            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                // dd('Ok il mio evento funziona!');

                //recuperiamo il form 
                $form = $event->getForm();

                // Recupero dei Dati dal Form
                $user = $form->getConfig()->getOptions()['data'];
                $passowrdHasher = $form->getConfig()->getOptions()['userPasswordHasher'];

                //Recupera le password inserita dall'utente e confronta a quella del db
                $isValid = $passowrdHasher->isPasswordValid(
                    $user,
                    $form->get('actualPassword')->getData() //recupera la password attuale
                );

                if (!$isValid) {
                    $form->get('actualPassword')->addError(
                        new FormError(
                            'La password attuale non è corretta'
                        )
                    );
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'userPasswordHasher' => false
        ]);
    }
}
