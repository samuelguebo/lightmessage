<?php namespace Lightmessage\Controllers;

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

		try {
			$data = filter_input_array( INPUT_POST );
			$message['status'] = 200;
			$message['data'] = $data;

		} catch ( Exception $e ) {
			$message['status'] = 400;
			$message['message'] = $error_not_found;
		} finally {
			echo json_encode( $message );
		}
	}
}
