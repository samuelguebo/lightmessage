<?php namespace Lightmessage\Utils;

use Exception;
use Lightmessage\Models\Message;

/**
 * Router responsible for redirecting
 * incoming request and mapping them
 * to the correct controller
 */
class Messenger {
	private $message;

	/**
	 * Constructor
	 *
	 * @param mixed $message
	 * @return void
	 */
	public function __construct( Message $message ) {
		$this->message = $message;
	}

	/**
	 * send
	 *
	 * @return mixed
	 */
	public function send() {
		try {
			if ( $this->isDuplicate() || !$this->canReceiveMessage() ) {
				throw new Exception();
			}

		} catch ( Exception $e ) {
			return false;
		}
	}

	/**
	 * isDuplicate
	 *
	 * @return boolean
	 */
	private function isDuplicate() {
	}

	/**
	 * canReceiveMessage
	 *
	 * @return void
	 */
	private function canReceiveMessage() {
	}

	/**
	 * getPostedMessage
	 *
	 * @return mixed
	 */
	private function getPostedMessages() {
		$messages = ( new MediaWiki )->getPageEdits( $this->message->wiki, $this->message->page, $this->message->author );

		return $messages;
	}
}
