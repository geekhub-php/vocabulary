<?php

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Word\Word;
use AppBundle\Entity\Word\WordTranslation;
use AppBundle\Entity\Whishlist\Wishlist;
use AppBundle\Entity\User\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;


class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
/*
        $word = new Word;
        $word->translate('UK')->setName('слон');
        $word->translate('EN')->setName('elephant');
        $word->translate('BEI')->setName('слон');
        $manager->persist($word);
        $word->mergeNewTranslations();
        $manager->flush();

        $word = new Word;
        $word->translate('UK')->setName('картопля');
        $word->translate('EN')->setName('potato');
        $word->translate('BEI')->setName('бульба');
        $manager->persist($word);
        $word->mergeNewTranslations();
        $manager->flush();

        $word = new Word;
        $word->translate('UK')->setName('сало');
        $word->translate('EN')->setName('creesh');
        $word->translate('BEI')->setName('сала');
        $manager->persist($word);
        $word->mergeNewTranslations();
        $manager->flush();

        $word = new Word;
        $word->translate('UK')->setName('батьківщина');
        $word->translate('EN')->setName('homeland');
        $word->translate('BEI')->setName('радзіма');
        $manager->persist($word);
        $word->mergeNewTranslations();
        $manager->flush();
        */
        $user = new User();
        $user->setLogin('user');

        //$user->setSalt(md5(uniqid()));
        $test_password = 'user';
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $test_password);
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $manager->persist($user);
        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}
