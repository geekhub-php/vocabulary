<?php

namespace Tests\AppBundle\Entity\User;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\HttpKernel\KernelInterface;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Common\DataFixtures\FixtureInterface;

abstract class TestCase extends KernelTestCase
    {

    public function setUp()
{
    self::bootKernel();

    self::prime(self::$kernel);


}

    public static function prime(KernelInterface $kernel)
    {
        // Make sure we are in the test environment
        if ('test' !== $kernel->getEnvironment()) {
            throw new \LogicException('Primer must be executed in the test environment');
        }

        // Get the entity manager from the service container
        $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        // Run the schema update tool using our entity metadata
        $metadatas = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metadatas);

        // If you are using the Doctrine Fixtures Bundle you could load these here
        $purger = new \Doctrine\Common\DataFixtures\Purger\ORMPurger($entityManager);
        $executor = new \Doctrine\Common\DataFixtures\Executor\ORMExecutor($entityManager, $purger);
        $executor->purge();

        // Load fixtures
        $loader = new \Doctrine\Common\DataFixtures\Loader;
        //$fixtures = new \Path\To\Your\Fixtures\MyFixtures();
        $fixtures = new \AppBundle\DataFixtures\ORM\LoadUserData();
        $fixtures->setContainer($kernel->getContainer());
        $loader->addFixture($fixtures);
        $executor->execute($loader->getFixtures());




    }

}
