<?php

namespace Lightmessage\Controllers;

/**
 * REST Controller for Job entities
 * and their relevant endpoints
 */
class NotFoundController extends AbstractController {
	/**
	 * Return error message
	 * in Json format
	 *
	 * @param mixed $request
	 * @return void
	 */
	public static function print( $request = null ) {
		$error_not_found = "The endpoint does not exist";

		header( "Content-type: application/json" );
		$message = [];
		$message['status'] = 400;
		$message['message'] = $error_not_found;

		echo json_encode( $message );
	}

	/**
	 * Redirect to an error message
	 * in order to mimic a 404 page
	 *
	 * @param mixed $request
	 * @param mixed $error
	 * @return void
	 */
	public static function redirect( $request = null, $error = null ) {
		if ( $error === null ) {
			$error = "The page does not exist";
		}

		require VIEW_DIR . "/404.php";
	}
}
