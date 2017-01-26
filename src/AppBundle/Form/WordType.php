<?php

namespace AppBundle\Form;


use AppBundle\Entity\Word;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text')
            ->add('translate', TranslateType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Word::class,
            'attr' => ['novalidate' => 'novalidate']
        ]);

    }

}