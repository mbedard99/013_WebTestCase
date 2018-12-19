<?php

namespace App\Tests;

//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Panther\PantherTestCase;

//class NewsControllerTest extends WebTestCase
class NewsControllerTest extends PantherTestCase
{
    public function testNews()
    {
//        $client = static::createClient();
	    $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Hello World', $crawler->filter('h1')->text());

	    $this->assertCount(2, $crawler->filter('h1'));
	    $this->assertSame(['week-601', 'symfony-live-usa-2018'], $crawler->filter('article')->extract('id'));

	    $link = $crawler->selectLink('Join us at SymfonyLive USA 2018!')->link();
	    $crawler = $client->click($link);

	    $this->assertSame('Join us at SymfonyLive USA 2018!', $crawler->filter('h1')->text());

    }
}
