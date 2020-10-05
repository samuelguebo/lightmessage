<?php namespace Lightmessage\Services;

use Exception;
use Lightmessage\Config\Settings;
use MediaWiki\OAuthClient\Client;
use MediaWiki\OAuthClient\ClientConfig;
use MediaWiki\OAuthClient\Consumer;
use MediaWiki\OAuthClient\Token;

/**
 * OAuth interacting with MediaWiki-based API
 * this its built-in OAuth extension.
 */
class OAuth {
	private $gTokenSecret;
	private $gTokenKey;
	private $errorCode = 200;

	/**
	 * Request authorization
	 * @return void
	 */
	public function doAuthorizationRedirect() {
		$token = $this->getRequestToken();
		$authURI = Router::getCookie( 'authURI' );

		// Redirect to authorization URI
		header( "Location: $authURI" );
	}

	/**
	 * Perform a generic edit
	 * @return void
	 */
	public function getProfile() {
		// Leverage cookie
		if ( !empty( Router::getCookie( 'userinfo' ) ) ) {
			return Router::getCookie( 'userinfo' );
		}

		$client = $this->getClient();
		$accessToken = new Token(
			Router::getCookie( 'accessToken' ),
			Router::getCookie( 'accessSecret' )
		);

		$res = $client->makeOAuthCall(
			$accessToken,
			Settings::$OAUTH_MWURI . '/w/api.php?action=query&meta=userinfo&format=json'
		);

		$res = json_decode( $res );

		if ( isset( $res->error->code ) && $res->error->code === 'mwoauth-invalid-authorization' ) {
			return;
		}

		if ( !isset( $res->query->userinfo ) ) {
			return;
		}
		if ( isset( $res->query->userinfo->anon ) ) {
			return;
		}

		// Identify
		$ident = $client->identify( $accessToken );

		// User rights
		$username = $res->query->userinfo->name;
		$hasRights = ( new ApiMediaWiki )->hasRights(
			Settings::$META_WIKI,
			Settings::$REQUIRED_RIGHTS,
			$username,
		);

		// Save to cookies
		Router::setcookie( 'isAllowed', $hasRights );
		Router::setcookie( 'userinfo', $username );

		return $username;
	}

	/**
	 * getClient
	 *
	 * @return void
	 */
	public function getClient() {
		$conf = new ClientConfig( Settings::$OAUTH_MWURI . '/w/index.php?title=Special:OAuth' );
		$conf->setConsumer( new Consumer(
			Settings::$OAUTH_KEY,
			Settings::$OAUTH_SECRET
		) );
		$client = new Client( $conf );
		return $client;
	}

	/**
	 * getAccessToken
	 *
	 * @return Token access token
	 */
	public function getAccessToken() {
		$client = $this->getClient();

		list( $authURI, $requestToken ) = $client->initiate();

		$oauth_verifier = filter_input( INPUT_GET, 'oauth_verifier' );
		$requestToken = new Token(
			Router::getCookie( 'requestToken' ),
			Router::getCookie( 'requestSecret' ),
		);

		$token = $client->complete(
			$requestToken,
			$oauth_verifier
		);

		if ( is_object( $token ) && isset( $token->error ) ) {
			header( "HTTP/1.1 $this->errorCode Internal Server Error" );
			throw new Exception( 'Error retrieving token: ' . $token->message );
		}
		if ( !is_object( $token ) || !isset( $token->key ) || !isset( $token->secret ) ) {
			header( "HTTP/1.1 $this->errorCode Internal Server Error" );
			throw new Exception( 'Invalid response from token request' );
		}

		// Save the access token
		Router::setcookie( 'loggedIn', true );
		Router::setcookie( 'accessToken', $token->key );
		Router::setcookie( 'accessSecret', $token->secret );
		return $token;
	}

	/**
	 * getRequestToken
	 *
	 * @return void
	 */
	private function getRequestToken() {
		$client = $this->getClient();
		list( $authURI, $token ) = $client->initiate();

		if ( is_object( $token ) && isset( $token->error ) ) {
			header( "HTTP/1.1 $this->errorCode Internal Server Error" );
			throw new Exception( 'Error retrieving token: ' . $token->message );
		}
		if ( !is_object( $token ) || !isset( $token->key ) || !isset( $token->secret ) ) {
			header( "HTTP/1.1 $this->errorCode Internal Server Error" );
			throw new Exception( 'Invalid response from token request' );
		}

		// Save the access token
		Router::setcookie( 'requestToken', $this->gTokenKey = $token->key );
		Router::setcookie( 'requestSecret', $this->gTokenSecret = $token->secret );
		Router::setcookie( 'authURI', $authURI );
		return $token;
	}

	/**
	 * Indicate whether the current user
	 * is logged in
	 *
	 * @return void
	 */
	public static function isLoggedIn() {
		$isLoggedIn = Router::getCookie( 'loggedIn' );
		return ( true === $isLoggedIn );
	}

	/**
	 * Indicate whether the current has enough rights
	 * to access the product
	 *
	 * @return void
	 */
	public static function isAllowed() {
		$isAllowed = Router::getCookie( 'isAllowed' );
		return ( true === $isAllowed );
	}
}
