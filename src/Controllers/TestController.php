<?php namespace Lightmessage\Controllers;

use Exception;
use Lightmessage\Models\Message;
use Lightmessage\Utils\MessageService;

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
			// TODO: Implement as needed
		} catch ( Exception $e ) {
			echo $e->getMessage();
		}
	}
}
