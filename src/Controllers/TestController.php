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
			$batchEs = new Batch(
				'CI opt-in notification (ES)',
				'* {{target | page = User talk:Samuel (WMF) | site = es.wikipedia.org}}',
				"Mensaje de test",
				"Hola, eso es un mensaje de test. No se preocupe :) !

				Haz [[:fr:User:African Hope|clic aquí para visitar]] un enlace. 
				"
			 );

			 $batchFR = new Batch(
				'CI opt-in notification (FR)',
				'* {{target | page = User talk:Samuel (WMF) | site = fr.wikipedia.org}}',
				"Message test",
				"Salut, c'est juste un message test. Pas de panique :) !

				Clique [[:es:User:African Hope|ici pour visiter]] un lien. 
				"
			 );
			 $wikicode = "* {{target | page = User talk:Samuel (WMF) | site = ja.wikipedia.org}}
			 * {{target | page = User talk:Samuel (WMF) | site = ar.wikipedia.org}}
			 * {{target | page = User talk:Samuel (WMF) | site = fr.wikipedia.org}}";

			 // $repository->createBatch( $batchFR );
			// print_r( $repository->fetch( 'batch' ) );
		} catch ( Exception $e ) {
			echo $e->getMessage();
		}
	}
}
