<?php
/*
Plugin Name: Markdown
Plugin URI:  https://github.com/goblindegook/wp-markdown-g
Description: Markdown formatting support.
Version:     1.3.0
Author:      Luís Rodrigues
Author URI:  http://goblindegook.net/
License:     GPLv2
*/

namespace goblindegook\WP\Markdown;


if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

\add_action( 'plugins_loaded', function () {
	$plugin = new Plugin( 'wp-markdown', '1.1.2' );
	$plugin->run();
} );
