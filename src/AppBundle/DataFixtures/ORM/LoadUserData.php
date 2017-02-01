<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('test1');
        $user1->setPassword('$2y$13$tdSH/5rRnu4nW7GZA5Bg6uRyfyvi7qCdu0Zf1SE0t6NIoErkU3od6');
        $user1->setEmail('john@gmail.com');
        $user1->setLocale('en');

        $user2 = new User();
        $user2->setUsername('test2');
        $user2->setPassword('$2y$13$SUKplxIZPaog1HnKC4GRrO8pcRtlatwQv1SR8ylNV2Fz0Rz9bHRt6');
        $user2->setEmail('alice@gmail.com');
        $user2->setLocale('ru');

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();

        $this->addReference('test1', $user1);
        $this->addReference('test2', $user2);
    }

    public function getOrder()
    {
        return 2;
    }
}
