<?php

use Lightmessage\Models\Batch;
use Lightmessage\Models\Message;
use Lightmessage\Services\MessageService;
use PHPUnit\Framework\TestCase;

class MessageServiceTest extends TestCase {
	protected $batch;
	protected $message;

	/**
	 * Fixture method for populating predefined
	 * data accessible accessible to other
	 * methods of the class
	 *
	 * @return void
	 */
	protected function setUp(): void {
		$this->message = new Message(
			'User talk:African Hope',
			'fr.wikipedia.org', 9,
			'Samuel (WMF)'
		);

		$this->batch = new Batch(
			null, null, 'Test avec ou sans Flow',
			null, null
		);
	}

	/**
	 * testIsDuplicate
	 *
	 * @covers \MessageService\isDuplicate
	 * @return void
	 */
	public function testIsDuplicate() {
		$service = new MessageService( $this->message, $this->batch );
		$this->assertTrue( $service->isDuplicate() );
	}

	/**
	 * testCanReceiveMessage
	 *
	 * @covers \MessageService\canReceiveMessage
	 * @return void
	 */
	public function testCanReceiveMessage() {
		$this->message = new Message(
			'User talk:Samuel (WMF)',
			'bn.wikisource.org', 7,
			'MediaWiki message delivery'
		);

		$service = new MessageService( $this->message, $this->batch );
		$this->assertFalse( $service->canReceiveMessage() );
	}
}
