<?php namespace Thenoun\Utils;

use Thenoun\Models\Message;
use Thenoun\Config\Settings;

/**
 * Respository in charge of Data persistence
 * and retrieving operations
 */
class BatchRepository {
	private $batch;

	/**
	 * Constructor
	 * @param mixed $batch
	 * @return void
	 */
	public function __construct( $batch = null ) {
		$this->batch = $batch;
	}

	/**
	 * Get list of offers
	 * @param int $limit
	 * @return array
	 */
	public function fetch( $limit = 3 ) {
		$result = [];
		return $result;
	}

	/**
	 * Save
	 * @param Message $message
	 * @return void
	 */
	public function create( Message $message ) {
		$error = false;
		return $error;
	}

	/**
	 * getDatabase
	 *
	 * @return void
	 */
	private function getDatabase() {
		$dataDir = dirname( __DIR__ ) . "/db";
	}	
}