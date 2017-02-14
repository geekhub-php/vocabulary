<?php

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Word\Word;
use AppBundle\Entity\Word\WordTranslation;
use AppBundle\Entity\Wishlist\Wishlist;
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

        $word = new Word;
        $word->translate('uk')->setName('слон');
        $word->translate('en')->setName('elephant');
        $word->translate('bel')->setName('слон');
        $manager->persist($word);
        $word->mergeNewTranslations();
        $manager->flush();

        $word = new Word;
        $word->translate('uk')->setName('картопля');
        $word->translate('en')->setName('potato');
        $word->translate('bel')->setName('бульба');
        $manager->persist($word);
        $word->mergeNewTranslations();
        $manager->flush();

        $word = new Word;
        $word->translate('uk')->setName('сало');
        $word->translate('en')->setName('creesh');
        $word->translate('bel')->setName('сала');
        $manager->persist($word);
        $word->mergeNewTranslations();
        $manager->flush();

        $word = new Word;
        $word->translate('uk')->setName('батьківщина');
        $word->translate('en')->setName('homeland');
        $word->translate('bel')->setName('радзіма');
        $manager->persist($word);
        $word->mergeNewTranslations();
        $manager->flush();
        $user = new User();
        $user->setUsername('user');

        //$user->setSalt(md5(uniqid()));
        $test_password = 'user';
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $test_password);
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $manager->persist($user);
        $manager->flush();


        $wishlist = new Wishlist();
        $user = $manager->getRepository('AppBundle:User\User')
            ->find('user');
            //->findBy(array('post' => $post->getId()));
        $wishlist->setUser($user);

        $word = $manager->getRepository('AppBundle:Word\Word')->findAll();
        $wishlist->setWords($word);

        $manager->persist($wishlist);
        $manager->flush();


       /* $word = $manager->getRepository('AppBundle:Word\Word')->find('2');
        $wishlist->addWord($word);
        $word = $manager->getRepository('AppBundle:Word\Word')->find('3');
        $wishlist->addWord($word);
        $word = $manager->getRepository('AppBundle:Word\Word')->find('4');
        $wishlist->addWord($word);
      */


    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}
