<?php


namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class WordControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client =  static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(
           1,
            $crawler->filter('html:contains("Welcome!")')->count()
        );
    }

    public function testNewNotAuthenticated()
    {
        $client =  static::createClient();

        $client->request('GET', '/word/new');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

}
