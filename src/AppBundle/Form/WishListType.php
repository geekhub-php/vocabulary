<?php

namespace AppBundle\Form;

use AppBundle\Entity\WishList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $wish_list = $event->getData();
            $locale = $wish_list->getUser()->getLocale();
            $form = $event->getForm();
            $form->add('words', EntityType::class, array(
                'class' => 'AppBundle:Word',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u');
                },
                'choice_label' => 'translations['.$locale.'].getName',
                'multiple' => true,
                'expanded' => true,

            ))
            ;
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => WishList::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'appbundle_wish_list';
    }
}
