<?php namespace Lightmessage\Controllers;

use Lightmessage\Models\BatchRepository;
use Lightmessage\Utils\OAuth;

/**
 * Controller handling homepage
 */
class HomeController extends AbstractController {
	/**
	 * Rest endpoint for route `/`
	 * it matches GET requests
	 * @param mixed $request
	 * @return void
	 */
	public function index( $request = null ) {
		if ( IS_LOGGEDIN ) {
			$oauth = new OAuth();
			$user = $oauth->getProfile();
			$batches = ( new BatchRepository )->fetch( 'batch', 1000 );
			// print_r( $batches );
			require VIEW_DIR . "/home/index.php";
		} else {
			require VIEW_DIR . "/home/logged-out.php";
		}
	}

	/**
	 * Rest endpoint for route `/about`
	 * it matches GET requests
	 * @param mixed $request
	 * @return void
	 */
	public function about( $request = null ) {
			require VIEW_DIR . "/home/about.php";
	}
}
