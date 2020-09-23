<?php namespace Lightmessage\Utils;

use Exception;
use Lightmessage\Models\Message;

/**
 * Service responsible for handling
 * outgoing messages through some
 * validation tests
 */
class MessageService {
	private $message;
	private $unsafe_interval;

	/**
	 * Constructor
	 *
	 * @param mixed $message
	 * @param int $unsafe_interval interval during which not new message should be posted
	 * @return void
	 */
	public function __construct( Message $message, $unsafe_interval ) {
		$this->message = $message;
		$this->unsafe_interval = $unsafe_interval;
	}

	/**
	 * Post messages only if certain conditions are met.
	 * Avoid duplication or posting to non-existent page
	 * @return mixed
	 */
	public function send() {
		try {
			if ( $this->isDuplicate() || !$this->canReceiveMessage() ) {
				throw new Exception();
			}

			// Post message to wiki
			$batch = ( new BatchRepository )->getBatchById( $this->message->batchId );

			$res = ( new MediaWiki )
				->addMessage(
					$this->message->wiki,
					$this->message->page,
					$batch['subject'],
					$batch['body']
				);

			if ( !isset( $res->edit ) ) {
				throw new Exception();
			}

			// If there are no errors, update $message in DB
			$this->message->setStatus( true );
			( new BatchRepository )->updateMessage( $this->message );

			return true;
		} catch ( Exception $e ) {
			return false;
		}
	}

	/**
	 * Check for duplication by verifying
	 * whether a message was already posted within the last 72 hours
	 * @return bool
	 */
	public function isDuplicate() {
		$messages = $this->getPostedMessages();
		try {

			foreach ( $messages as $message ) {
				// Logger::log( $message );
				$edit_timestamp = strtotime( $message['timestamp'] );

				// Get timestamp of safe interval
				$since = strtotime( "-" . $this->unsafe_interval . " hour" );

				// continue verification if edit was made within safe interval
				if ( ( $since < $edit_timestamp ) ) {

					// Check whether author during the unsafe interval
					$interval = ( $since - $edit_timestamp ) / 3600;
					if ( $interval < $this->unsafe_interval && ( $message['user'] === $this->message->author ) ) {
						return true;
					}

				}

			}
		} catch ( Exception $e ) {

			return false;
		}

		return false;
	}

	/**
	 * canReceiveMessage
	 *
	 * @return void
	 */
	public function canReceiveMessage() {
		return ( new MediaWiki )->isPageExistent(
			$this->message->wiki,
			$this->message->page
		);
	}

	/**
	 * getPostedMessage
	 *
	 * @return mixed
	 */
	public function getPostedMessages() {
		return ( new MediaWiki )->getPageEdits(
			$this->message->wiki,
			$this->message->page,
			$this->message->author
		);
	}
}
