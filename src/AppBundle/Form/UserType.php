<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'required' => true,
                'label' => 'User Name',

            ])
            ->add('password', RepeatedType::class, [
                   'type' => PasswordType::class,
                   'required' => true,
                   'first_options' => ['label' => 'Password*'],
                   'second_options' => ['label' => 'Repeat Password*'],
                           ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email',
                'attr' => ['class' => 'test col-xs-6'],
            ])
            ->add('locale', ChoiceType::class, array(
                'choices' => array(
                    'English' => 'en',
                    'French' => 'fr',
                    'German' => 'de',
                    'Russian' => 'ru',
                    'Ukrainian' => 'ua',

                ),
                'choices_as_values' => true,
                'required' => true,
                'label' => 'Choose language',
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();
            if ($user->getId()) {
                $form->remove('username');
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,

        ));
    }

    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }
}
