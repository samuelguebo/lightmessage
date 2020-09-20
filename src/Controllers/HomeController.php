<?php namespace Lightmessage\Controllers;

use Lightmessage\Config\Settings;
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
		if ( AuthController::isLoggedIn() ) {
			$oauth = new OAuth();
			$user = $oauth->getProfile()->query->userinfo;
			require VIEW_DIR . "/home/index.php";
		} else {
			require VIEW_DIR . "/home/logged-out.php";
		}
	}
}
