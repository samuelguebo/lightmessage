<?php namespace Lightmessage\Controllers;

use Exception;
use Lightmessage\Models\Batch;
use Lightmessage\Utils\BatchRepository;
use Lightmessage\Utils\Router;

/**
 * Controller handling message batches
 */
class BatchController extends AbstractController {
	/**
	 * Rest endpoint for route `/batch/create`
	 * it matches GET requests
	 * @param mixed $request
	 * @return void
	 */
	public function create( $request = null ) {
		require VIEW_DIR . "/batch/update.php";
	}

	/**
	 * Rest endpoint for route `/batch/save`
	 * it matches POST requests
	 * @param mixed $request
	 * @return void
	 */
	public function save( $request = null ) {
		try {
			$data = filter_input_array( INPUT_POST );
			if ( !empty( $data['title'] ) &&
			!empty( $data['wikicode'] ) &&
			!empty( $data['subject'] ) &&
			!empty( $data['body'] ) ) {
				$batch = new Batch(
					$data['title'],
					$data['wikicode'],
					$data['subject'],
					$data['body']
				);

				// Set $id if in the middle of update
				if ( !empty( $data['id'] ) ) {
					$batch->setId( $data['id'] );
				}

				$repository = new BatchRepository;
				$res = $repository->createOrUpdateBatch( $batch );

				// Redirect to home if there are no errors
				header( "Location: /" );
			} else {
				throw new Exception;
			}
		} catch ( Exception $e ) {
			require VIEW_DIR . "/404.php";
		}
	}

	/**
	 * Rest endpoint for route `/batch/view`
	 * it matches GET requests
	 * @param mixed $request
	 * @return void
	 */
	public function view( $request = null ) {
			$batchId = Router::getParam( $request );
			$repository = new BatchRepository;
			$batch = $repository->getBatchById( $batchId );
			if ( !empty( $batch ) ) {
				$messages = $repository->getBatchMessages( $batchId );
				require VIEW_DIR . "/batch/view.php";
			} else {

				require VIEW_DIR . "/404.php";

			}
	}

	/**
	 * Rest endpoint for route `/batch/create`
	 * it matches GET requests
	 * @param mixed $request
	 * @return void
	 */
	public function update( $request = null ) {
		$batchId = Router::getParam( $request );
		$repository = new BatchRepository;
		$batch = $repository->getBatchById( $batchId );
		$messages = $repository->getBatchMessages( $batchId );
		require VIEW_DIR . "/batch/update.php";
	}

	/**
	 * Rest endpoint for route `/batch/delete`
	 * it matches GET requests
	 * @param mixed $request
	 * @return void
	 */
	public function delete( $request = null ) {
		$batchId = Router::getParam( $request );
		$repository = new BatchRepository;
		$batch = $repository->getBatchById( $batchId );
		if ( !empty( $batch ) ) {
			$messages = $repository->deleteBatchById( $batchId );
			// Redirect to home if there are no errors
			header( "Location: /" );
		} else {
			require VIEW_DIR . "/404.php";
		}
	}
}
