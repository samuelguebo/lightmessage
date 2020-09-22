<?php namespace Lightmessage\Controllers;

use Exception;
use Lightmessage\Utils\BatchRepository;
use Lightmessage\Utils\Messenger;

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
			$repository = new BatchRepository;
			$message = $repository->fetch( 'message', 3 )[2];
			$messenger = new Messenger;
			// print_r( $message );
			// print_r( $messenger->getPostedMessage( Message::fromArray( $message ) ) );

		} catch ( Exception $e ) {
			echo $e->getMessage();
		}
	}
}
