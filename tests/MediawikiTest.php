<?php

use Lightmessage\Models\Message;
use Lightmessage\Utils\MediaWiki;
use PHPUnit\Framework\TestCase;

class MediawikiTest extends TestCase {
	/**
	 * testHasFlowEnabled
	 *
	 * @covers \Lightmessage\Utils\Mediawiki
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
}
