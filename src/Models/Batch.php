<?php
namespace Lightmessage\Models;

/**
 * Entity that holds the data for processed
 * and related to a batch list
 */
class Batch {
	public $title;
	public $wikicode;
	public $subject;
	public $body;

	/**
	 * Default constructor
	 *
	 * @param string $title
	 * @param string $wikicode
	 * @param string $subject
	 * @param string $body
	 * @return void
	 */
	public function __construct( $title, $wikicode, $subject, $body ) {
		$this->title  = $title;
		$this->wikicode = $wikicode;
		$this->subject = $subject;
		$this->body = $body;
	}
}
