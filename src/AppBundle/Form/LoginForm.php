<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('_username', TextType::class, array(
            'required' => false,
            'label' => 'user.form.login.label._username',
                'constraints' => [
                    new NotBlank(array(
                        'message' => 'user.form.login.error',
                    ))
                ]
            )
        )
            ->add('_password', PasswordType::class, array(
                'label' => 'user.form.login.label._password',
                'required' => false,
                'constraints' => [
                    new NotBlank(array(
                        'message' => 'user.form.login.error',
                    ))
                ]
            ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'em' => ObjectManager::class,
            ]);
    }
}
