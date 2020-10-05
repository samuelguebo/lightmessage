<?php namespace Lightmessage\Controllers;

use Exception;
use Lightmessage\Models\Batch;
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
		$output = [];
		try {
			$data = filter_input_array( INPUT_POST );

			if ( isset( $data['data'] ) ) {
				$data = json_decode( $data['data'], true );
				$repository = new BatchRepository;
				$message = $repository->getMessageById( $data['id'] );

				// As Repository uses NoSQL, results are arrays
				$message = Message::fromArray( $message );
				$batch 	 = $repository->getBatchById( $data['batchId'] );
				$batch 	 = Batch::fromArray( $batch );
				$response = ( new MessageService( $message, $batch ) )->send();

				// If no data was sent
				throw new Exception( $response );
			}

			// If no data was sent
			throw new Exception( Message::MISSING );

		} catch ( Exception $e ) {
			$output['response'] = $e->getMessage();
		}

		header( "Content-type: application/json" );
		echo json_encode( $output );
	}
}
