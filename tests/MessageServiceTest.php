<?php

use Lightmessage\Models\Message;
use Lightmessage\Utils\MessageService;
use PHPUnit\Framework\TestCase;

class MessageServiceTest extends TestCase {
	/**
	 * testIsDuplicate
	 *
	 * @covers \MessageService\
	 * @return void
	 */
	public function testIsDuplicate() {
		$message = new Message(
			'User talk:African Hope',
			'fr.wikipedia.org', 9,
			'Samuel (WMF)'
		);

		$unsafe_interval = 3 * 24;
		$service = new MessageService( $message, $unsafe_interval );
		$this->assertTrue( $service->isDuplicate() );
	}

	/**
	 * testCanReceiveMessage
	 *
	 * @covers \MessageService\
	 * @return void
	 */
	public function testCanReceiveMessage() {
		$message = new Message(
			'User talk:Samuel (WMF)',
			'bn.wikisource.org', 7,
			'MediaWiki message delivery'
		);

		$unsafe_interval = 3 * 24;
		$service = new MessageService( $message, $unsafe_interval );
		$this->assertFalse( $service->canReceiveMessage() );
	}
}
