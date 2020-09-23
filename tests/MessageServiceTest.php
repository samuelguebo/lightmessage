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

		$service = new MessageService( $message );
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

		$service = new MessageService( $message );
		$this->assertFalse( $service->canReceiveMessage() );
	}
}
