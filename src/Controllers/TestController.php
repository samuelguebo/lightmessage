<?php namespace Lightmessage\Controllers;

use Exception;

/**
 * Controller handling homepage
 */
class TestController extends AbstractController {

	/**
	 * Testing
	 * @param mixed $request
	 * @return void
	 */
	public function test( $request ) {
		try {
			// Implement as needed
		} catch ( Exception $e ) {
			echo $e->getMessage();
		}
	}
}
