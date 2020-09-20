<?php namespace Lightmessage\Controllers;

use Lightmessage\Config\Settings;

/**
 * Abstract class for Controllers
 * it can be extended to create
 * additional controllers
 */
abstract class AbstractController {
	public function __construct() {
	}

	/**
	 * Generic middleware shared accross
	 * all child classes
	 *
	 * @param mixed $route
	 * @param mixed $request
	 * @return void
	 */
	public function middleWare( $route, $request ) {
		// Check wether wether user is logged in or not
		if ( ( $route['protected'] ) ) {
			if ( !AuthController::isLoggedIn() ) {
				AuthController::unauthorized( $request );
				exit();
			}
		}

		define( 'APP_NAME', Settings::$APP_NAME );
		define( 'APP_SLOGAN', Settings::$APP_SLOGAN );
		define( 'APP_DESCRIPTION', Settings::$APP_DESCRIPTION );
		define( 'VIEW_DIR', dirname( __DIR__ ) . '/Views' );
	}

}
