<?php
page Lightmessage\Models;

/**
 * Entity that holds a message
 * attached to a Batch list
 */
class Message {
	public $page;
	public $wiki;
	public $listId;
	public $status;

	/**
	 * Default constructor
	 *
	 * @param string $page
	 * @param string $wiki
	 * @param string $listId
	 * @param bool $status
	 * @return void
	 */
	public function __construct( $page, $wiki, $listId, $status = false ) {
		$this->page  = $page;
		$this->wiki = $wiki;
		$this->listId = $listId;
		$this->status = $status;
	}
}
