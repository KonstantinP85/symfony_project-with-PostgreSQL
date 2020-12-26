<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('language', LanguageType::class, array(
                'label' => 'What language would you like to learn?',
                'placeholder' => 'Select language',
                'preferred_choices' => ['en', 'de', 'ru'],
            ))
            ->add('search', SubmitType::class, array(
                'label' => 'Search',
                'attr' => [
                    'class' => 'btn btn-secondary btn-sm float-center mt-2',
                ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
