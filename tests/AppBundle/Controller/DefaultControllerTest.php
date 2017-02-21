<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $local=array(0=>'bel',1=>'en',2=>'uk');
        $client = static::createClient();

        $crawler = $client->request('POST', '/');
        $response = $client->getResponse();

        $this->assertEquals(405, $client->getResponse()->getStatusCode());


        foreach ($local as $value) {
          $crawler = $client->request('GET','/'.$value);
            $response = $client->getResponse();

            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }

        //$this->assertContains('Welcome to my site friend', $crawler->filter('#container h1')->text());

        $crawler = $client->request('GET', '/');
        //$this->assertEquals(200, $client->getResponse()->getStatusCode());
        foreach ($local as $value) {
            $link = $crawler
                ->filter('a:contains('.strtoupper($value).')') // find all links with the text "Greet"
                ->eq(0) // select the second link in the list
                ->link()
            ;
            $crawler = $client->click($link);
        }
    }
}