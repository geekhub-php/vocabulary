<?php

namespace tests\AppBundle\Controller;


use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;


class UserControllerTest extends WebTestCase
{
    public function testLogin()
    {
        /** @var Client $client */
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertCount(
            3,
            $crawler->filter('input')
        );

        $this->assertCount(
            1,
            $crawler->filter('h1')
        );
    }


    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/registration');

        $this->assertCount(
            4,
            $crawler->filter('input')
        );



        $crawler = $client->request('GET', '/registration');

        $form = $crawler->selectButton('Save')->form();
        $form['registration[username]'] = 'DorianGray';
        $form['registration[password][first]'] = 'Qwer1234';
        $form['registration[password][second]'] = 'Qwer1234';
        $form['registration[locale]']->select('uk');

        $client->submit($form);
        /** @var User $user */
        $user = $client->getContainer()
            ->get('doctrine')
            ->getRepository('AppBundle:User')
            ->findByUsername('DorianGray');

        $this->assertEquals('DorianGray', $user->getUsername());
        $this->assertEquals('uk', $user->getLocale());
        $this->assertTrue($client->getResponse()->isRedirection());
    }
}
