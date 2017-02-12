<?php

namespace tests\AppBundle\Controller;


use AppBundle\Controller\WordController;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WordControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        /** @var User $user */
        $user = static::createClient()
            ->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:User')
            ->findRandomOne();

        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => $user->getUsername(),
            'PHP_AUTH_PW'   => 'Qwer1234',
        ));
    }

    public function testNotAuthenticated()
    {
        $client = static::createClient();

        $client->request('GET', '/vocabulary/learning');

        $this->assertTrue($client->getResponse()->isRedirect());
    }

    public function testAuthentication()
    {

        $this->client->request('GET', '/vocabulary/learning');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testShowFavorite()
    {
        $crawler = $this->client->request('GET', '/vocabulary/learning');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->filter('h1'));

    }


    public function testAddNewWord()
    {
        $crawler = $this->client->request('GET', '/vocabulary/words/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertCount(6, $crawler->filter('input'));
        $this->assertCount(1, $crawler->filter('button'));
    }
}
