<?php namespace Lightmessage\Controllers;

use Exception;
use Lightmessage\Models\Batch;
use Lightmessage\Utils\BatchRepository;

/**
 * Controller handling homepage
 */
class TestController extends AbstractController {

	/**
	 * Testing
	 * @param mixed $request
	 * @return void
	 */
	public function test( $request ) {
		try {
			$repository = new BatchRepository;
			$batch = new Batch( 'CI opt-in notification (ES)', '* {{target | page = User talk:Samuel (WMF) | site = fr.wikipedia.org}}' );
			// $repository->createBatch( $batch );
			print_r( $repository->fetch( 'batch' ) );
		} catch ( Exception $e ) {
			echo $e->getMessage();
		}
	}
}
