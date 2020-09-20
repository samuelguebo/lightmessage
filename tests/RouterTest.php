<?php
use Lightmessage\Utils\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {
	/**
	 * testCanCreateRouter
	 *
	 * @covers \Router\
	 * @return void
	 */
	public function testCanCreateRouter() {
		$_SERVER['REQUEST_URI'] = null;
		$router = new Router( null, null );

		$this->assertEquals( is_object( $router ), true );
	}
}
