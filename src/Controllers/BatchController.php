<?php namespace Lightmessage\Controllers;

use Lightmessage\Utils\Router;
use Lightmessage\Utils\BatchRepository;

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
		require VIEW_DIR . "/batch/create.php";
	}

	/**
	 * Rest endpoint for route `/batch/save`
	 * it matches POST requests
	 * @param mixed $request
	 * @return void
	 */
	public function save( $request = null ) {
		// Save data to Database
	}

	/**
	 * Rest endpoint for route `/batch/view`
	 * it matches GET requests
	 * @param mixed $request
	 * @return void
	 */
	public function view( $request = null ) {
		$batchId = Router::getParam( $request );
		$batch = ( new BatchRepository )->getBatchById( 'batch', $batchId );
		require VIEW_DIR . "/batch/view.php";
	}
}
