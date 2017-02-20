<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider getPublicUrls
     */
    public function testPublicUrls($url)
    {
        $client = self::createClient();

        $client->request('GET', $url);
        $this->assertTrue(
            $client->getResponse()->isSuccessful(),
            sprintf('The %s public URL loads correctly.', $url)
        );
    }

    /**
     * @dataProvider getSecureUrls
     */
    public function testSecureUrls($url)
    {
        $client = self::createClient();

        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isRedirect());
        $this->assertEquals(
            'http://localhost/en/login',
            $client->getResponse()->getTargetUrl(),
            sprintf('The %s secure URL redirects to the login form.', $url)
        );
    }

    public function getPublicUrls()
    {
        return array(
            array('/'),
            array('/en/2'),
            array('/en/signup'),
            array('/en/login'),
            array('/en/users/2'),
        );
    }

    public function getSecureUrls()
    {
        return array(
            array('/en/users/2/edit'),
            array('/en/words/new'),
            array('/en/words/1/edit'),
            array('/en/wishlist/2'),
        );
    }
}
