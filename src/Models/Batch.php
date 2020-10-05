<?php
namespace Lightmessage\Models;

/**
 * Entity that holds the data for processed
 * and related to a batch list
 */
class Batch {
	public $id;
	public $title;
	public $wikicode;
	public $subject;
	public $body;
	public $author;

	/**
	 * Default constructor
	 *
	 * @param string $title
	 * @param string $wikicode
	 * @param string $subject
	 * @param string $body
	 * @param string $author
	 * @return void
	 */
	public function __construct( $title, $wikicode, $subject, $body, $author ) {
		$this->title  = $title;
		$this->wikicode = $wikicode;
		$this->subject = $subject;
		$this->body = $body;
		$this->author = $author;
	}

	/**
	 * Setter for Id
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
	 * @param mixed $batch
	 * @return void
	 */
	public static function fromArray( $batch ) {
		try {
			$batchObj = new Batch(
				$batch['title'],
				$batch['wikicode'],
				$batch['subject'],
				$batch['body'],
				$batch['author']
			);
			$batchObj->setId( $batch['_id'] );

			return $batchObj;
		} catch ( Exception $e ) {
			return [];
		}
	}
}
