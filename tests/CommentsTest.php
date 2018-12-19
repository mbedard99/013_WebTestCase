<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class CommentsTest extends PantherTestCase {
	public function testComments() {
		$client = static::createPantherClient();
		$crawler = $client->request( 'GET', '/news/symfony-live-usa-2018' );

		$client->waitFor( '#post-comment' ); // Wait for the form to appear, it may take some time because it's done in JS
		$form = $crawler->filter( '#post-comment' )->form( [ 'new-comment' => 'Symfony is so cool!' ] );
		$client->submit( $form );

		$client->waitFor( '#comments ol' ); // Wait for the comments to appear

		$this->assertSame( self::$baseUri . '/news/symfony-live-usa-2018',
			$client->getCurrentURL() ); // Assert we're still on the same page
		$this->assertSame( 'Symfony is so cool!', $crawler->filter( '#comments ol li:first-child' )->text() );
	}
}
