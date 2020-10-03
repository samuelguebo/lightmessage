<?php namespace Lightmessage\Services;

/**
 * Service helping print data in JavaScript console
 * and which can come in handy during debugging
 */
class Logger {
	/**
	 * Printing arbitrary data
	 * in the browser console
	 * @param mixed $data
	 * @return void
	 */
	public static function log( $data ) {
		// Convert array and object to JSON text
		if ( is_object( $data ) || is_array( $data ) ) {
			$data = json_encode( $data );
		}
		echo ( "<script>console.log(`" . $data . "`)</script>" );
	}
}
