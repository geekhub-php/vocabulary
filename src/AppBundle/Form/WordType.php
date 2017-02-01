<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

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

        $builder
            ->add('word');

        if (isset($this->authorizationChecker) && $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $builder->add('user', EntityType::class, array(
                'class' => 'AppBundle:User',
                'choice_label' => 'userProfile.firstName userProfile.lastName',
                'label' => 'Author',
            ));
        }

        $builder->add('save', SubmitType::class);
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
