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
			$res = $db
					->where( '_id', '=', $batchId )
					->fetch();
			if ( isset( $res[0] ) ) {
				return $res[0];
			} else {
				throw new Exception();
			}
		} catch ( Exception $e ) {
			return [];
		}
	}

	/**
	 * Get a message based on its Id
	 * @param int $messageId
	 * @return array
	 */
	public function getMessageById( $messageId ) {
		try {
			$db = $this->getTableData( 'message' );
			$res = $db
					->where( '_id', '=', $messageId )
					->fetch();
			if ( isset( $res[0] ) ) {
				return $res[0];
			} else {
				throw new Exception();
			}
		} catch ( Exception $e ) {
			return [];
		}
	}

	/**
	 * Assert whether batch exists in Database
	 * @param int $batchId
	 * @return array
	 */
	public function batchExistsById( $batchId ) {
		try {
			$db = $this->getTableData( 'batch' );
			return count( $db
					->where( '_id', '=', $batchId )
					->fetch() ) > 0;
		} catch ( Exception $e ) {
			return false;
		}
	}

	/**
	 * Assert whether message exists in Database
	 * @param Object $message
	 * @return array
	 */
	public function messageExists( $message ) {
		try {
			$db = $this->getTableData( 'message' );
			return count( $db
					->where( 'page', '=', $message->page )
					->where( 'wiki', '=', $message->wiki )
					->where( 'batchId', '=', $message->batchId )
					->fetch() ) > 0;
		} catch ( Exception $e ) {
			return false;
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
			$res = $db->insert( $data );

			// Get child messages from wikicode list
			$childMessages = $this->wikicodeToMessages( $res['wikicode'], $res['_id'], $res['author'] );
			// Logger::log( [ 'childMessages', $childMessages ] );
			foreach ( $childMessages as $message ) {
				$message->setStatus( false );
				$this->createMessage( $message );
			}

			return $res;
		} catch ( Exception $e ) {
			return $error;
		}
	}

	/**
	 * Save batch
	 * @param int $batchId
	 * @return void
	 */
	public function deleteBatchById( $batchId ) {
		$error = false;
		try {
			$batchDb = $this->getTableData( 'batch' );
			$batchDb->where( '_id', '=', $batchId )->delete();
			$messageDb = $this->getTableData( 'message' );

			// Delete all child messages
			$messageDb->where( 'batchId', '=', $batchId )->delete();
		} catch ( Exception $e ) {
		}
	}

	/**
	 * Switch between create or update operations
	 * @param Batch $batch
	 * @return mixed
	 */
	public function createOrUpdateBatch( Batch $batch ) {
		if ( $this->batchExistsById( $batch->id ) ) {
			return $this->updateBatch( $batch );
		} else {
			return $this->createBatch( $batch );
		}
	}

	/**
	 * Update batch
	 * @param Batch $batch
	 * @return void
	 */
	public function updateBatch( Batch $batch ) {
		$error = false;
		try {
			$db = $this->getTableData( 'batch' );
			$data = (array)$batch;

			$res = $db
					->where( '_id', '=', $batch->id )
					->update( $data );

			// Update existing childMessages
			$childMessages = $this->wikicodeToMessages( $batch->wikicode, $batch->id, $batch->author );
			foreach ( $childMessages as $message ) {
				if ( !$this->messageExists( $message ) ) {
					$this->createMessage( $message );
				} else {
					// Discard update, on purpose
					// $this->updateMessage( $message );
				}
			}
		} catch ( Exception $e ) {
			return $error;
		}
	}

	/**
	 * Update message
	 * @param Message $message
	 * @return void
	 */
	public function updateMessage( Message $message ) {
		$error = false;
		try {
			$db = $this->getTableData( 'message' );
			$data = (array)$message;

			return $db
					->where( 'page', '=', $message->page )
					->where( 'wiki', '=', $message->wiki )
					->where( 'batchId', '=', $message->batchId )
					->update( $data );
		} catch ( Exception $e ) {
			return $error;
		}
	}

	/**
	 * Extract messages from wikicode
	 *
	 * @param string $wikicode
	 * @param string $batchId
	 * @param string $author
	 * @return array list of Message ojects
	 */
	public function wikicodeToMessages( $wikicode, $batchId, $author ) {
		$messages = [];
		$lines = explode( "\n", $wikicode );
		foreach ( $lines as $line ) {
		   preg_match( '/=(.*).*\|.*=(.*).*}}/', $line, $matches );
		   if ( count( $matches ) > 1 ) {
			   $page = trim( $matches[1] );
			   $wiki = trim( $matches[2] );
			   $messages[] = new Message( $page, $wiki, $batchId, $author );
		   }
		}

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
