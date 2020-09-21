<?php namespace Lightmessage\Controllers;

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
		print_r($request);
		//$batchId = $_GET['']
		//$batch = ( new BatchRepository )->getBatchById( 'batch', 1000 );
		//require VIEW_DIR . "/batch/view.php";
	}
}
