<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class WordType extends AbstractType
{
    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->authorizationChecker = $options['authorizationChecker'];

        $builder->add('translations', TranslationsType::class, array(
            'label' => false,
            'fields' => array(
                'word' => array(
                    'label' => 'word.titleOne'
                )
            )
        ));

        if (isset($this->authorizationChecker) && $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $builder->add('user', EntityType::class, array(
                'class' => 'AppBundle:User',
                'choice_label' => 'username',
                'label' => 'base.author'
            ));
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'           => 'AppBundle\Entity\Word',
            'attr'                 => array('novalidate' => 'novalidate'),
            'authorizationChecker' => null
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
