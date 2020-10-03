<?php namespace Lightmessage\Controllers;

use Exception;
use Lightmessage\Models\Message;
use Lightmessage\Services\MessageService;

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
			$message = new Message(
				'User talk:Samuel (WMF)',
				'fr.wiktionary.org', 9,
				'Samuel (WMF)'
			);

			$unsafe_interval = 3 * 24;
			$service = new MessageService( $message, $unsafe_interval );
		} catch ( Exception $e ) {
			echo $e->getMessage();
		}
	}
}
