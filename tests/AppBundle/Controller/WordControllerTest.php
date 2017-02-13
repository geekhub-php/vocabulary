<?php

namespace tests\AppBundle\Controller;


use AppBundle\Controller\WordController;
use AppBundle\DataFixtures\ORM\LoadFixtures;
use AppBundle\Entity\User;
use AppBundle\Entity\Word;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;


class WordControllerTest extends WebTestCase
{
    /** @var Client client */
    private $client;
    /** @var  EntityManager */
    private $em;

    public function setUp()
    {

        $this->em = static::createClient()
            ->getContainer()->get('doctrine.orm.default_entity_manager');

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

    public function testEditWord()
    {
        /** @var Word $word */
        $word = $this->em
            ->getRepository('AppBundle:Word')
            ->findRandomOne();
        $crawler = $this->client->request('GET', '/vocabulary/words/edit/'.$word->getId());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertCount(6, $crawler->filter('input'));
        $this->assertCount(1, $crawler->filter('button'));

        $form = $crawler->selectButton('Save')->form();
        $form['form[ukrainian]'] = 'ukrainian';
        $form['form[english]'] = 'english';
        $form['form[russian]'] = 'russian';
        $form['form[german]'] = 'german';
        $form['form[italian]'] = 'DDDDDDDDDDDDDDDDDDDDDD';


        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->assertEquals($word->translate('en')->getName(), 'english');
        $this->assertEquals($word->translate('uk')->getName(), 'ukrainian');
        $this->assertEquals($word->translate('it')->getName(), 'DDDDDDDDDDDDDDDDDDDDDD');
        $this->assertEquals($word->translate('de')->getName(), 'german');
        $this->assertEquals($word->translate('ru')->getName(), 'russian');

    }

    public function testSecuredArea()
    {
        $this->client->request('GET', '/login');

        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/registration');

        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }
}
