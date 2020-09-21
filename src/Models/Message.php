<?php
namespace Lightmessage\Models;

/**
 * Entity that holds a message
 * attached to a Batch list
 */
class Message {
	public $page;
	public $wiki;
	public $batchId;
	public $status;

	/**
	 * Default constructor
	 *
	 * @param string $page
	 * @param string $wiki
	 * @param string $batchId
	 * @return void
	 */
	public function __construct( $page, $wiki, $batchId ) {
		$this->page  = $page;
		$this->wiki = $wiki;
		$this->batchId = $batchId;
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

}
