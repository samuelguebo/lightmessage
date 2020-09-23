<?php namespace Lightmessage\Controllers;

use Exception;
use Lightmessage\Models\Message;
use Lightmessage\Utils\BatchRepository;
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
			$repository = new BatchRepository;
			$message = $repository->fetch( 'message', 3 )[2];
			$messenger = new MessageService( Message::fromArray( $message ) );
			// print_r( $message );
			// $messenger->send();
		} catch ( Exception $e ) {
			echo $e->getMessage();
		}
	}
}
