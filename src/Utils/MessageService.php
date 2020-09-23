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
	 * Post messages only if certain conditions are met.
	 * Avoid duplication or posting to non-existent page
	 *
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
	 *
	 * @return bool
	 */
	public function isDuplicate() {
		$messages = $this->getPostedMessages();
		foreach ( $messages as $message ) {
			// Get timestamp of three days ago
			$three_days_ago = strtotime( date( "F j, Y", time() - 60 * 60 * 72 ) );
			// Logger::log( $message );
			$edit_timestamp = strtotime( $message['timestamp'] );

			// continue if edit was made within the last three days
			if ( !( $edit_timestamp > $three_days_ago ) ) {

				// Check whether author posted less than 72 hours
				$interval = ( $three_days_ago - $edit_timestamp ) / 3600;
				if ( $interval < 72 && ( $message['user'] === $this->message->author ) ) {
					return true;
				}

			}

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
