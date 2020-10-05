<?php namespace Lightmessage\Controllers;

use Lightmessage\Config\Settings;
use Lightmessage\Models\BatchRepository;
use Lightmessage\Services\OAuth;

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
		$oauth = new OAuth();

		if ( $oauth->isLoggedIn() ) {
			$user = $oauth->getProfile();

			// Check user rights
			if ( !$oauth->isAllowed() ) {
				$error = "Sorry, you are not allowed to access this page.";
				$error .= " You need the following rights: " . implode( " ,", Settings::$REQUIRED_RIGHTS );
				NotFoundController::redirect( $request, $error );
				return;
			}

			if ( !empty( $user ) ) {
				$batches = ( new BatchRepository )->fetch( 'batch' );
				require VIEW_DIR . "/home/index.php";
				return;
			}

			// If an error occured while getting
		}

		require VIEW_DIR . "/home/logged-out.php";
	}

	/**
	 * Rest endpoint for route `/about`
	 * it matches GET requests
	 * @param mixed $request
	 * @return void
	 */
	public function about( $request = null ) {
		header( 'Location: ' . Settings::$ABOUT_PAGE );
	}
}
