<?php

namespace AppBundle\Form;


use AppBundle\Entity\Translate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranslateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ukrainian')
            ->add('russian')
            ->add('german')
            ->add('italian')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Translate::class,
            'attr' => ['novalidate' => 'novalidate']
        ]);

    }
}