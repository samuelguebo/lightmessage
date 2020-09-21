<?php namespace Lightmessage\Utils;

use Exception;
use Lightmessage\Models\Batch;
use Lightmessage\Models\Message;
use SleekDB\SleekDB;

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
	 * @param string $table
	 * @param int $limit
	 * @return array
	 */
	public function fetch( $table, $limit = 3 ) {
		try {
			$db = $this->getTableData( $table );
			return $db
					->limit( $limit )
					->fetch( $table );
		} catch ( Exception $e ) {
			return [];
		}
	}

	/**
	 * Get a batch based on its Id
	 * @param string $table
	 * @param int $batchId
	 * @return array
	 */
	public function getBatchById( $table, $batchId ) {
		try {
			$db = $this->getTableData( $table );
			return $db
					->where( '_id', '=', $batchId )
					->fetch();
		} catch ( Exception $e ) {
			return [];
		}
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
		$dataDir = dirname( __DIR__ ) . "/../database";
		$tableData = SleekDB::store( $table, $dataDir );
		return $tableData;
	}
}
