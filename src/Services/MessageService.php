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
	 * @param Batch $batch parent batch
	 * @return void
	 */
	public function __construct( Message $message, $batch ) {
		$this->message = $message;
		$this->batch = $batch;
	}

	/**
	 * Post messages only if certain conditions are met.
	 * Avoid duplication or posting to non-existent page
	 * @return mixed
	 */
	public function send() {
		try {
			if ( $this->isDuplicate() ) {
				throw new Exception( 'delivered' );
			}

			if ( !$this->canReceiveMessage() ) {
				throw new Exception( 'empty' );
			}

			// Post message to wiki

			$res = ( new MediaWiki )
				->addMessage(
					$this->message->wiki,
					$this->message->page,
					$this->batch->subject,
					$this->batch->body,
					"/* " . $this->batch->subject . " - " . $this->batch->title . " */"
				);

			if ( !isset( $res->edit ) ) {
				throw new Exception( 'unknown-error' );
			}

			// If there are no errors, update $message in DB
			$this->message->setStatus( true );
			( new BatchRepository )->updateMessage( $this->message );

			return true;
		} catch ( Exception $e ) {
			// update $message in DB
			$error = 'unknown-error';
			if ( in_array( $e->getMessage(), [ 'delivered', 'empty' ] ) ) {
				$error = $e->getMessage();
			}
			$this->message->setStatus( $error );
			( new BatchRepository )->updateMessage( $this->message );
			return $error;
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

	/**
	 * getSections
	 *
	 * @return mixed
	 */
	public function getSections() {
		return ( new MediaWiki )->getPageSections(
			$this->message->wiki,
			$this->message->page
		);
	}
}
