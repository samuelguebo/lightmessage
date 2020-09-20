<?php namespace Lightmessage\Utils;

use Exception;
use SleekDB;
use Lightmessage\Models\Message;

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
	 * Save message
	 * @param Message $message
	 * @return void
	 */
	public function createMessage( Message $message ) {
		$error = false;
		try {
			$db = $this->getTableData( 'message' );
			$data = (array)$message;
			return $db->insert( $data );
		} catch ( Exception $e ) {
			return $error;
		}
	}

	/**
	 * Save batch
	 * @param Batch $batch
	 * @return void
	 */
	public function createBatch( Batch $batch ) {
		$error = false;
		try {
			$db = $this->getTableData( 'batch' );
			$data = (array)$batch;
			return $db->insert( $data );
		} catch ( Exception $e ) {
			return $error;
		}
	}

	/**
	 * getTableData
	 * @param string $table
	 * @return void
	 */
	private function getTableData( $table ) {
		$dataDir = dirname( __DIR__ ) . "/db";
		$tableData = SleekDB::store( $table, $dataDir );
	}
}
