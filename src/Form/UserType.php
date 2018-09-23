<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Prénom'],
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Nom'],
            ])
            ->add('phone', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Téléphone'],
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Email'],
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => ['attr' => ['placeholder' => 'Mot de passe']],
                'second_options'  => ['attr' => ['placeholder' => 'Confirmation']],
                'invalid_message' => 'La confirmation ne correspond pas.'
            ))
            ->add('newsletter', CheckboxType::class, [
                'required' => false,
                'label' => 'J\'accepte de recevoir des emails de notifications.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
