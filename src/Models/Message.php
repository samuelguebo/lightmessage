<?php
namespace Lightmessage\Models;

use Exception;

/**
 * Entity that holds a message
 * attached to a Batch list
 */
class Message {
	public $page;
	public $wiki;
	public $status;
	public $author;
	public $batchId;
	public $id;
	public const PENDING 	= 'pending';
	public const DELIVERED 	= 'delivered';
	public const FAILED 	= 'failed';
	public const MISSING 	= 'not found';

	/**
	 * Default constructor
	 *
	 * @param string $page
	 * @param string $wiki
	 * @param string $batchId
	 * @param string $author
	 * @return void
	 */
	public function __construct( $page, $wiki, $batchId, $author ) {
		$this->page  = $page;
		$this->wiki = $wiki;
		$this->batchId = $batchId;
		$this->author = $author;
		$this->status = self::PENDING;
	}

	/**
	 * Setter for status
	 *
	 * @param mixed $status
	 * @return void
	 */
	public function setStatus( $status ) {
		$this->status = $status;
	}

	/**
	 * Setter for id
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * fromArray
	 *
	 * @param mixed $message
	 * @return void
	 */
	public static function fromArray( $message ) {
		try {
			$messageObj = new Message( $message['page'], $message['wiki'], $message['batchId'], $message['author'] );
			$messageObj->setId( $message['_id'] );

			return $messageObj;
		} catch ( Exception $e ) {
			return [];
		}
	}
}
