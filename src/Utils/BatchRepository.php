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
	 * @param int $batchId
	 * @return array
	 */
	public function getBatchById( $batchId ) {
		try {
			$db = $this->getTableData( 'batch' );
			return $db
					->where( '_id', '=', $batchId )
					->fetch()[0];
		} catch ( Exception $e ) {
			return [];
		}
	}

	/**
	 * Get all child messages attached to a list
	 * by specifiying the parent batch's id
	 * @param int $batchId
	 * @return array
	 */
	public function getBatchMessages( $batchId ) {
		try {
			$db = $this->getTableData( 'message' );
			return $db
					->where( 'batchId', '=', $batchId )
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
	 * Extract messages from wikicode
	 *
	 * @param string $wikicode
	 * @param string $batchId
	 * @return array list of Message ojects
	 */
	public function wikicodeToMessages( $wikicode, $batchId ) {
		$messages = [];
		$lines = explode( "\n", $wikicode );
		foreach ( $lines as $line ) {
		   preg_match( '/page = (.*) \| site = (.*)[ ]?}}/', $line, $matches );
		   if ( count( $matches ) > 1 ) {
			   $page = $matches[1];
			   $wiki = $matches[2];
			   $messages[] = new Message( $page, $wiki, $batchId );
		   }
		}
		// Logger::log( [ '$messages', $messages ] );
		return $messages;
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
