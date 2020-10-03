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

			// Switch to Flow is target page has Flow enabled
			if ( $this->hasFlowEnabled( $wiki, $page ) ) {
				return $this->addFlowMessage( $wiki, $page, $subject, $body, $summary );
			}
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
				'bot' => true,
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
	public function addFlowMessage( $wiki, $page, $subject, $body ) {
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
	 * Check whether an account has certain rights
	 *
	 * @param string $wiki
	 * @param mixed $rights
	 * @param string $user
	 * @return bool
	 */
	public function hasRights( $wiki, $rights, $user ) {
		$rights = (array)$rights;

		$response = file_get_contents( 'https://' . $wiki . "/w/api.php?action=query&meta=globaluserinfo&format=json&guiuser=" . urlencode( $user ) . "&guiprop=groups" );
		$results = json_decode( $response, true )['query']['globaluserinfo'];
		if ( array_key_exists( "missing", $results ) ) {
			return false;
		}

		// Count interesctions, the total should match count($rights)
		if ( count( array_intersect( $results['groups'], $rights ) ) === count( $rights ) ) {
			return true;
		}

		return false;
	}

	/**
	 * isPageExistent
	 *
	 * @param mixed $wiki
	 * @param mixed $page
	 * @return bool
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
	 * Detect $whether page has flow
	 *
	 * @param mixed $wiki
	 * @param mixed $page
	 * @return bool
	 */
	public function hasFlowEnabled( $wiki, $page ) {
		try {
			// Trimming
			$wiki = trim( $wiki );
			$page = trim( $page );

			$response = file_get_contents( 'https://' . $wiki . "/w/api.php" . "?action=query&prop=revisions&titles=" . urlencode( $page ) . "&rvslots=main&rvprop=content&format=json" );

			$model = array_values( json_decode( $response, true )['query']['pages'] )['0']['revisions']['0']['slots']['main']['contentmodel'];
			return ( $model === 'flow-board' );

		} catch ( Exception $e ) {
			return false;
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
			// print_r( [ 'response', $response ] );
			return array_values( json_decode( $response, true )['query']['pages'] )['0']['revisions'];
		} catch ( Exception $e ) {
			return [];
		}
	}
}
