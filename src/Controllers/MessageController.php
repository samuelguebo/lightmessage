<?php namespace Lightmessage\Controllers;

use Exception;
use Lightmessage\Models\Message;
use Lightmessage\Utils\BatchRepository;
use Lightmessage\Utils\Messenger;

/**
 * Controller handling Message delivery
 */
class MessageController extends AbstractController {
	/**
	 * Rest endpoint for route `/message/send`
	 * it matches GET requests
	 * @param mixed $request
	 * @return void
	 */
	public function send( $request = null ) {
		header( "Content-type: application/json" );
		$message = [];
		$error_not_found = "Invalid request";
		try {
			$data = filter_input_array( INPUT_POST );
			$message['status'] = 200;

			if ( isset( $data['data'] ) ) {
				$data = json_decode( $data['data'], true );
				$repository = new BatchRepository;
				$message = $repository->getMessageById( $data['id'] );
				$messenger = new Messenger( Message::fromArray( $message ) );
				$response = $messenger->send();
				$message['response'] = $response;
			} else {
				throw new Exception();
			}

		} catch ( Exception $e ) {
			$message['status'] = 400;
			$message['message'] = $error_not_found;
		} finally {
			echo json_encode( $message );
		}
	}
}
