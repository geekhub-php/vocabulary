<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WordControllerTest extends WebTestCase
{
    private $defaultUser = array(
        'PHP_AUTH_USER' => 'user',
        'PHP_AUTH_PW'   => 'user',
    );

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Vocabulary', $crawler->filter('.navbar-brand')->text());
        $this->assertEquals(5, $crawler->filter('table tbody tr')->count(), '5 words per page.');
    }

    public function testNew()
    {
        $client = static::createClient(array(), $this->defaultUser);

        $crawler = $client->request('GET', '/en/words/new');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('form[name=appbundle_word]')->form();
        $crawler = $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertRegexp(
            '/This value should not be blank/',
            $client->getResponse()->getContent()
        );

        $form['appbundle_word[translations][en][word]'] = 'NewWordEn';
        $form['appbundle_word[translations][uk][word]'] = 'NewWordUk';
        $form['appbundle_word[translations][ru][word]'] = 'NewWordRu';
        $form['appbundle_word[translations][fr][word]'] = 'NewWordFr';
        $form['appbundle_word[translations][es][word]'] = 'NewWordEs';
        $crawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();
        $this->assertContains(
            'NewWordEn',
            $client->getResponse()->getContent()
        );
        $this->assertContains(
            'NewWordUk',
            $client->getResponse()->getContent()
        );
        $this->assertContains(
            'NewWordRu',
            $client->getResponse()->getContent()
        );
        $this->assertContains(
            'NewWordFr',
            $client->getResponse()->getContent()
        );
        $this->assertContains(
            'NewWordEs',
            $client->getResponse()->getContent()
        );
    }

    public function testEdit()
    {
        $client = static::createClient(array(), $this->defaultUser);

        $container = self::$kernel->getContainer();
        $em = $container->get('doctrine')->getManager();
        $word = $em->getRepository('AppBundle:WordTranslation')
            ->findOneBy(array('word' => 'NewWordEn'));

        $crawler = $client->request('GET', '/en/words/'.$word->getTranslatable()->getId().'/edit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('form[name=appbundle_word]')->form();
        $form['appbundle_word[translations][en][word]'] = 'NewWordEnEdited';
        $form['appbundle_word[translations][uk][word]'] = 'NewWordUkEdited';
        $form['appbundle_word[translations][ru][word]'] = 'NewWordRuEdited';
        $form['appbundle_word[translations][fr][word]'] = 'NewWordFrEdited';
        $form['appbundle_word[translations][es][word]'] = 'NewWordEsEdited';
        $crawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();
        $this->assertContains(
            'NewWordEnEdited',
            $client->getResponse()->getContent()
        );
        $this->assertContains(
            'NewWordUkEdited',
            $client->getResponse()->getContent()
        );
        $this->assertContains(
            'NewWordRuEdited',
            $client->getResponse()->getContent()
        );
        $this->assertContains(
            'NewWordFrEdited',
            $client->getResponse()->getContent()
        );
        $this->assertContains(
            'NewWordEsEdited',
            $client->getResponse()->getContent()
        );
    }
}
