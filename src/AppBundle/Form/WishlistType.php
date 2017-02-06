<?php
/**
 * Created by PhpStorm.
 * User: nima
 * Date: 25.12.16
 * Time: 14:35.
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use AppBundle\Entity\Word\Word;
use Doctrine\ORM\EntityRepository;


class WishlistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('words', EntityType::class, array(
                'class' => 'AppBundle:Word\Word',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('w');
                           },
                'choice_label' => 'translations[UK].getName',
                'multiple' => true,
                'expanded' => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Wishlist\Wishlist',
            'em' => null,
        ));
        $resolver->addAllowedTypes('em', [ObjectManager::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_wishlist';
    }
}
