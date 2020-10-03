<?php namespace Lightmessage\Controllers;

use Exception;
use Lightmessage\Models\BatchRepository;
use Lightmessage\Models\Message;
use Lightmessage\Services\MessageService;

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
		$output = [];
		$error_not_found = "Invalid request";
		try {
			$data = filter_input_array( INPUT_POST );

			if ( isset( $data['data'] ) ) {
				$data = json_decode( $data['data'], true );
				$message = ( new BatchRepository )->getMessageById( $data['id'] );
				$message = Message::fromArray( $message );

				// Set a safe interval of 3 days hours between next delivery
				$safe_interval = 3 * 24;
				$response = ( new MessageService( $message, $safe_interval ) )->send();

				if ( !$response ) {
					$output['data'] = $response;
					throw new Exception();
				}

				$output['data'] = $data;
				$ouput['response'] = true;
			} else {
				throw new Exception();
			}

		} catch ( Exception $e ) {
			$output['response'] = false;
		} finally {
			echo json_encode( $output );
			// echo json_encode( $message );
		}
	}
}
