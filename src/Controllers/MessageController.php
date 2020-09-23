<?php namespace Lightmessage\Controllers;

use Exception;
use Lightmessage\Models\Message;
use Lightmessage\Utils\BatchRepository;
use Lightmessage\Utils\MessageService;

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

			if ( isset( $data['data'] ) ) {
				$data = json_decode( $data['data'], true );
				$message = ( new BatchRepository )->getMessageById( $data['id'] );
				$response = ( new MessageService( Message::fromArray( $message ) ) )->send();
				if ( !$response ) {
					throw new Exception();
				}

				$message['data'] = $data;
				$message['response'] = true;
			} else {
				throw new Exception();
			}

		} catch ( Exception $e ) {
			$message['response'] = false;
		} finally {
			echo json_encode( $message );
			// echo json_encode( $message );
		}
	}
}
