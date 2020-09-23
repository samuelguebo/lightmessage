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
			$message = ( new BatchRepository )->getMessageById( 107 );
			$service = new MessageService( Message::fromArray( $message ) );
			// print_r( Message::fromArray( $message ) );
			// print_r( $service->send() );
		} catch ( Exception $e ) {
			echo $e->getMessage();
		}
	}
}
