<?php
namespace Thenoun\Models;

/**
 * Entity that holds a message
 * attached to a Batch list
 */
class Message {
	public $namespace;
	public $wiki;
	public $listId;
	public $status;

	/**
	 * Default constructor
	 *
	 * @param string $namespace
	 * @param string $wiki
	 * @param string $listId
	 * @param bool $status
	 * @return void
	 */
	public function __construct( $namespace, $wiki, $listId, $status = false ) {
		$this->namespace  = $namespace;
		$this->wiki = $wiki;
		$this->listId = $listId;
		$this->status = $status;
	}
}
