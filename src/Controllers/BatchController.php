<?php namespace Thenoun\Controllers;

use Thenoun\Config\Settings;
use Thenoun\Utils\OAuth;

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
		require ROOT . "/src/Views/batch/create.php";
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
}
