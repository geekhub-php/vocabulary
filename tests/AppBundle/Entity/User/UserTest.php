<?php

namespace Tests\AppBundle\Entity\User;



class UserTest extends TestCase
{
    public function testGenerateLocalization()
    {
        /*$this->location->setAddress('14 Rue Notre-Dame-des-Victoires');
        $this->location->setZipCode('75002');
        $this->location->setCity('Paris');
        $this->location->setCountry('FR');

        // Save the location
        $this->entityManager->persist($this->location);
        $this->entityManager->flush();

        $this->assertEquals('14 Rue Notre-Dame-des-Victoires 75002 Paris FR', $this->location->getLocalization());
    */
        $userName=self::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User\User')
            ->findByNameUser('user');
        $this->assertCount(1, $userName);
    //printf($word) ;
    }
}



