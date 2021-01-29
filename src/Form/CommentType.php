<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('notation', ChoiceType::class, [
                'label' => 'Note',
                'choices' => [
                    '5' => '5',
                    '4' => '4',
                    '3' => '3',
                    '2' => '2',
                    '1' => '1'
                ],
                'expanded' => true,
                'required' => true
            ])
            ->add('author', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom',
                    'autocomplete' => 'off',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 30
                    ])
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre commentaire',
                'attr' => [
                    'placeholder' => 'Entrez votre commentaire',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'rows' => '5'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 255
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
