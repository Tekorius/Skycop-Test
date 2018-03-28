<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User form used in registration and account edit.
 *
 * boolean 'registration' option is required
 */
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\Email(),
                ],
            ])
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('country', CountryType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Country(),
                ],
            ])
            ->add('city', ChoiceType::class, [
                // All available choices are loaded here to hack around initial value selection
                // Not a good thing, but again - demo
                'choices' => [
                    'Vilnius' => 'Vilnius',
                    'Kaunas' => 'Kaunas',
                    'Klaipeda' => 'Klaipeda',
                    'Kabul' => 'Kabul',
                    'Los Angeles' => 'Los Angeles',
                    'Austin' => 'Austin',
                    'Martinsville' => 'Martinsville',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
        ;

        // NOTE: I know this is a shotty implementation at best, but I don't have any more unpaid hours to burn :)
        if ($options['registration']) {
            // This is a registration use case
            $builder->add('password', RepeatedType::class, [
                'mapped' => false,
                'required' => true,
                'type' => PasswordType::class,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 8]),
                ],
            ]);
        } else {
            // This is an account edit use case
            $builder->add('password', RepeatedType::class, [
                'mapped' => false,
                'required' => false,
                'type' => PasswordType::class,
                'constraints' => [
                    new Assert\Length(['min' => 8]),
                ],
            ]);
        }

        // Disable choice field transformer to allow any value
        // NOTE: I know this can be changed and is not a right method of validation, but again, demo
        $builder->get('city')->resetViewTransformers();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('registration');

        $resolver->setDefaults([
            'data_class' => User::class,
            'registration' => false,
        ]);
    }
}
