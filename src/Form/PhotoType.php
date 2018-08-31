<?php

namespace App\Form;

use App\Entity\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, [
                'required' => false,
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Titre'],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description',
                'attr' => ['placeholder' => 'Description'],
            ])
            ->add('takenAt', DateType::class, [
                'required' => false,
                'label' => 'Photo prise le',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
