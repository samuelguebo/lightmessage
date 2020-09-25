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
	 * @param mixed $summary
	 * @return string / error
	 */
	public function addMessage( $wiki, $page, $subject, $body, $summary ) {
		try {
			// Trimming
			$wiki = trim( $wiki );
			$page = trim( $page );
			$subject = trim( $subject );

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
				'section' => 'new',
				'sectiontitle' => $subject,
				'text' => $body,
				'summary' => $summary,
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
	 * Create new topic on a page that supports Flow
	 *
	 * @param mixed $wiki wiki url (without protocol)
	 * @param mixed $page Name space
	 * @param mixed $subject Section title
	 * @param mixed $body text in special markup (wikicode)
	 * @return string / error
	 */
	public function addFlowMessage( $wiki, $page, $subject, $body) {
		try {
			// Trimming
			$wiki = trim( $wiki );
			$page = trim( $page );
			$subject = trim( $subject );

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
				'action' => 'flow',
				'page' => $page,
				'submodule' => 'new-topic',
				'nttopic' => $subject,
				'ntcontent' => $body,
				'token' => $user->getEditToken(),
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
			// Trimming
			$wiki = trim( $wiki );
			$page = trim( $page );

			$response = file_get_contents( 'https://' . $wiki . "/w/api.php" . "?action=query&prop=revisions&titles=" . urlencode( $page ) . "&rvslots=*&rvprop=content&format=json" );
			return !array_key_exists( "-1", json_decode( $response, true )['query']['pages'] );

		} catch ( Exception $e ) {
			return true;
		}
	}

	/**
	 * getPageEdits
	 *
	 * @param mixed $wiki
	 * @param mixed $page
	 * @param mixed $author
	 * @param mixed $limit
	 * @return array
	 */
	public function getPageEdits( $wiki, $page, $author = null, $limit = 50 ) {
		try{
			// Trimming
			$wiki = trim( $wiki );
			$page = trim( $page );

			// Make sure page exists
			if ( !$this->isPageExistent( $wiki, $page ) ) {
				throw new Exception();
			}

			$query_url = "https://" . $wiki . "/w/api.php" . "?action=query&prop=revisions";
			$query_url .= "&rvprop=user|timestamp|comment|ids";
			$query_url .= "&titles=" . urlencode( $page ) . "&rvlimit=$limit&format=json&origin=*";

			$response = file_get_contents( $query_url );
			return array_values( json_decode( $response, true )['query']['pages'] )['0']['revisions'];
		} catch ( Exception $e ) {
			return [];
		}
	}
}
