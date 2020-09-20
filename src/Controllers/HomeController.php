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
		define( 'APP_NAME', Settings::$APP_NAME );
		define( 'APP_SLOGAN', Settings::$APP_SLOGAN );
		define( 'APP_DESCRIPTION', Settings::$APP_DESCRIPTION );

		if ( AuthController::isLoggedIn() ) {
			$oauth = new OAuth();
			$user = $oauth->getProfile()->query->userinfo;
			require ROOT . "/src/Views/index.php";
		} else {
			require ROOT . "/src/Views/logged-out.php";
		}
	}
}
