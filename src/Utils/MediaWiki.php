<?php namespace Lightmessage\Utils;

use Exception;
use MediaWiki\OAuthClient\Token;

/**
 * Oauth mechanism
 */

class MediaWiki {
	private $gTokenSecret;
	private $gTokenKey;
	private $errorCode = 200;

	/**
	 * Edit a sandbox on Wikimedia Commons
	 *
	 * @param mixed $wiki wiki url (without protocol)
	 * @param mixed $page Name space
	 * @param mixed $subject Section title
	 * @param mixed $body text in special markup (wikicode)
	 * @return string / error
	 */
	public function addMessage( $wiki, $page, $subject, $body ) {
		try {
			$client = ( new OAuth() )->getClient();
			$accessToken = new Token(
				Router::getCookie( 'accessToken' ),
				Router::getCookie( 'accessSecret' )
			);

			// Get edit token
			$token = json_decode( $client->makeOAuthCall(
				$accessToken,
				'https://' . $wiki . "/w/api.php" . '?action=query&meta=tokens&format=json'
			) )->query->tokens->csrftoken;

			// Perform the edit
			$params = [
				'format' => 'json',
				'action' => 'edit',
				'title' => $page,
				'sectiontitle' => 'new',
				'sectiontitle' => $subject,
				'text' => $body,
				'summary' => "/* $subject */",
				'watchlist' => 'nochange',
				'token' => $token,
			];

			// Get response
			$res = json_decode( $client->makeOAuthCall(
				$accessToken,
				'https://' . $wiki . "/w/api.php",
				true,
				$params
			) );

			return $res;
		} catch ( Exception $e ) {
			return $e->getMessage();
		}
	}

	/**
	 * isPageExistent
	 *
	 * @param mixed $wiki
	 * @param mixed $page
	 * @return void
	 */
	public function isPageExistent( $wiki, $page ) {
		try {
			$response = file_get_contents( 'https://' . $wiki . "/w/api.php" . "?action=query&prop=revisions&titles=" . urlencode( $page ) . "&rvslots=*&rvprop=content&format=json" );
			return !array_key_exists( "-1", json_decode( $response, true )['query']['pages'] );

		} catch ( Exception $e ) {
			return true;
		}
	}
}
