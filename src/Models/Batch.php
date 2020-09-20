<?php
namespace Thenoun\Models;

/**
 * Entity that holds the data for processed
 * and related to a batch list
 */
class Batch {
	public $title;
	public $wikicode;

	/**
	 * Default constructor
	 *
	 * @param string $title
	 * @param string $wikicode
	 * @return void
	 */
	public function __construct( $title, $wikicode ) {
		$this->title  = $title;
		$this->wikicode = $wikicode;
	}
}
