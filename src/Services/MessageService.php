<?php namespace Lightmessage\Services;

use Exception;
use Lightmessage\Models\Batch;
use Lightmessage\Models\BatchRepository;
use Lightmessage\Models\Message;

/**
 * Service responsible for handling
 * outgoing messages through some
 * validation tests
 */
class MessageService {
	private $message;
	private $batch;

	/**
	 * Constructor
	 *
	 * @param mixed $message
	 * @param Batch $batch Parent batch
	 * @return string Error message
	 */
	public function __construct( Message $message, $batch ) {
		$this->message = $message;
		$this->batch = $batch;
	}

	/**
	 * Post messages only if certain conditions are met.
	 * Avoid duplication or posting to non-existent page
	 * @return bool
	 */
	public function send() {
		try {
			// Check whether page exists
			if ( !$this->canReceiveMessage() ) {
				throw new Exception( Message::MISSING );
			}

			// Check for duplication
			if ( $this->isDuplicate() ) {
				throw new Exception( Message::DELIVERED );
			}

			// As there are no errors, post message to page
			$res = ( new ApiMediaWiki )
				->addMessage(
					$this->message->wiki,
					$this->message->page,
					$this->batch->subject,
					$this->batch->body,
					"/* " . $this->batch->subject . " - " . $this->batch->title . " */"
				);

			if ( isset( $res->error ) ) {
				throw new Exception( Message::FAILED );
			}

			// If there are no errors, update $message in DB
			$this->message->setStatus( MESSAGE::DELIVERED );
			( new BatchRepository )->updateMessage( $this->message );

			return MESSAGE::DELIVERED;
		} catch ( Exception $error ) {

			// Update database with message error
			$this->message->setStatus( $error->getMessage() );
			( new BatchRepository )->updateMessage( $this->message );
			return $error->getMessage();
		}
	}

	/**
	 * Check for duplication by verifying
	 * whether a message was already posted within the last 72 hours
	 * @return bool
	 */
	public function isDuplicate() {
		$sections = $this->getSections();
		try {
			foreach ( $sections as $section ) {
				if ( $section['line'] === $this->batch->subject ) {
					return true;
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
		return ( new ApiMediaWiki )->isPageExistent(
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
		return ( new ApiMediaWiki )->getPageEdits(
			$this->message->wiki,
			$this->message->page,
			$this->message->author
		);
	}

	/**
	 * getSections
	 *
	 * @return mixed
	 */
	public function getSections() {
		return ( new ApiMediaWiki )->getPageSections(
			$this->message->wiki,
			$this->message->page
		);
	}
}
