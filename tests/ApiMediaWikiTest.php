<?php

use Lightmessage\Models\Message;
use Lightmessage\Services\ApiMediaWiki;
use PHPUnit\Framework\TestCase;

class ApiMediaWikiTest extends TestCase {
	/**
	 * testHasFlowEnabled
	 *
	 * @covers \Lightmessage\Services\Apiiadiki
	 * @return void
	 */
	public function testHasFlowEnabled() {
		$message = new Message(
			'User talk:وهراني',
			'ar.wikipedia.org', 9,
			'Samuel (WMF)'
		);

		$hasFlowEnabled = ( new ApiMediaWiki )->hasFlowEnabled(
			$message->wiki,
			$message->page,
		);

		$this->assertTrue( $hasFlowEnabled );
	}

	/**
	 * testHasRights
	 * @covers \Lightmessage\Services\ApiMediaWiki
	 * @return void
	 */
	public function testHasRights() {
		$wiki = 'meta.wikimedia.org';
		$rights = [ 'otrs-member', 'steward' ];
		$user = '-revi';

		$hasRights = ( new ApiMediaWiki )->hasRights(
			$wiki,
			$rights,
			$user,
		);

		$this->assertTrue( $hasRights );
	}
}
