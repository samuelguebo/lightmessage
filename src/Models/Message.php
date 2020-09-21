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
	 * @param bool $status
	 * @return void
	 */
	public function __construct( $page, $wiki, $batchId, $status = false ) {
		$this->page  = $page;
		$this->wiki = $wiki;
		$this->batchId = $batchId;
		$this->status = $status;
	}
}
