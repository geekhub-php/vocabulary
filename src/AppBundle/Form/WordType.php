<?php

namespace AppBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class WordType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('word_eng', TextType::class, [
            'required' => false,
            'label' => 'word.form.new.label.en',
            'constraints' => [
                new NotBlank()
            ]
        ])
        ->add('word_ru', TextType::class, [
            'required' => false,
            'label' => 'word.form.new.label.ru',
            'constraints' => [
                new NotBlank()
            ]
        ])
        ->add('word_ua', TextType::class, [
            'required' => false,
            'label' => 'word.form.new.label.ua',
            'constraints' => [
                new NotBlank()
            ]
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'em' => ObjectManager::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_word';
    }
}
