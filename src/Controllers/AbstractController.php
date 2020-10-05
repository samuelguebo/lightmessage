<?php namespace Lightmessage\Controllers;

use Lightmessage\Config\Settings;
use Lightmessage\Services\OAuth;

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
		define( 'APP_NAME', Settings::$APP_NAME );
		define( 'APP_SLOGAN', Settings::$APP_SLOGAN );
		define( 'APP_DESCRIPTION', Settings::$APP_DESCRIPTION );
		define( 'VIEW_DIR', dirname( __DIR__ ) . '/Views' );

		// Check wether wether user is logged in or not
		if ( ( $route['protected'] ) ) {
			if ( !OAuth::isLoggedIn() ) {
				AuthController::unauthorized( $request );
				exit();
			}

			if ( !OAuth::isAllowed() ) {
				$error = "Sorry, you are not allowed to access this page.";
				$error .= " You need the following rights: " . implode( " ,", Settings::$REQUIRED_RIGHTS );
				NotFoundController::redirect( $request, $error );
				exit();
			}
		}

		define( 'IS_LOGGEDIN', OAuth::isLoggedIn() );
		define( 'IS_ALLOWED', OAuth::isAllowed() );
	}

}
