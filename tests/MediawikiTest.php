<?php

use Lightmessage\Models\Message;
use Lightmessage\Services\MediaWiki;
use PHPUnit\Framework\TestCase;

class MediawikiTest extends TestCase {
	/**
	 * testHasFlowEnabled
	 *
	 * @covers \Lightmessage\Services\Mediawiki
	 * @return void
	 */
	public function testHasFlowEnabled() {
		$message = new Message(
			'User talk:وهراني',
			'ar.wikipedia.org', 9,
			'Samuel (WMF)'
		);

		$hasFlowEnabled = ( new MediaWiki )->hasFlowEnabled(
			$message->wiki,
			$message->page,
		);

		$this->assertTrue( $hasFlowEnabled );
	}

	/**
	 * testHasRights
	 * @covers \Lightmessage\Services\Mediawiki
	 * @return void
	 */
	public function testHasRights() {
		$wiki = 'meta.wikimedia.org';
		$rights = [ 'otrs-member', 'steward' ];
		$user = '-revi';

		$hasRights = ( new MediaWiki )->hasRights(
			$wiki,
			$rights,
			$user,
		);

		$this->assertTrue( $hasRights );
	}
}
