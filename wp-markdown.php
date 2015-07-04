<?php
/*
Plugin Name: Markdown
Plugin URI:  http://goblindegook.net/
Description: Markdown formatting support.
Version:     1.0.0
Author:      Luís Rodrigues
Author URI:  http://goblindegook.net/
License:     GPLv2
*/

if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use \goblindegook\WP\Markdown\Plugin;

\add_action( 'plugins_loaded', function () {
	$plugin = new Plugin( 'wp-markdown', '1.0.0' );
	$plugin->run();
} );
