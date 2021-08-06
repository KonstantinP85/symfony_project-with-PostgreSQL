<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, array(
                'label' => 'Foto',
                'required' => false,
                'mapped' => false,
            ))
            ->add('Name',TextType::class, array(
                'label' => 'Name',
                'attr' => [
                    'placeholder' => '',
                ]
            ))
            ->add('language', LanguageType::class, array(
                'label' => 'Language',
                'required' => false,
                'placeholder' => 'Select your language',
                'preferred_choices' => [],
            ))
            ->add('is_public')
            ->add('Country', CountryType::class, array(
                'label' => 'Country',
                'required' => false,
                'placeholder' => 'Select your country',
                'preferred_choices' => [],
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-secondary float-left mr-5',
                ]
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
