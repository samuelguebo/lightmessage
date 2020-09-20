<?php

use Lightmessage\Config\Settings;
use Lightmessage\Utils\Router;

/**
 * Main entry point for the application
 * Serves as request dispatcher
 */

define( 'ROOT', __DIR__ );

// Autoloading and global settings
require ROOT . '/vendor/autoload.php';

// Handle dispatching
$router = ( new Router( Settings::$ROUTES ) )->dispatch();
