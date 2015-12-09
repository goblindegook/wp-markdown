<?php

namespace goblindegook\WP\Markdown;

/**
 * Markdown exporter.
 */
class Exporter {

	/**
	 * Plugin instance.
	 * @var Plugin
	 */
	private $plugin;

	/**
	 * Converter constructor.
	 * @param Plugin $plugin Plugin instance.
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Setup export query var.
	 */
	public function filter_query_vars( $vars ) {
		$vars[] = 'export';
		return $vars;
	}

	/**
	 * Setup rewrite rules for the `.text` slug extension.
	 *
	 * Allows fetching the raw Markdown used on the page.
	 */
	public function filter_rewrite_rules( $rewrite ) {

		$md_rewrite = array();

		foreach ( $rewrite as $pattern => $redirect ) {
			if ( preg_match( '/name=/', $redirect ) && preg_match( '/page=/', $redirect ) ) {
				// Repurpose the paged rewrite rules:
				
				$md_pattern  = str_replace( '(?:/([0-9]+))?/?$', '\.text/?$', $pattern );
				$md_pattern  = str_replace( '(/[0-9]+)?/?$', '\.text/?$', $md_pattern );
				$md_redirect = preg_replace( '/([&?])page=[^\&]*/', '$1export=markdown', $redirect, 1 );

				$md_rewrite[ $md_pattern ] = $md_redirect;
			}
		}

		return array_merge( $md_rewrite, $rewrite );
	}

	/**
	 * Handle text URL response.
	 */
	public function text() {
		global $post;

		if ( \is_singular() && \get_query_var( 'export' ) === 'markdown'
			&& $post->post_status === 'publish' && $post->post_password === '' ) {

			header( 'Content-Type: text/markdown; charset=' . \get_bloginfo( 'charset' ) );
			
			$metadata = array(
				'Title'  => \get_the_title(),
				'Author' => \get_the_author_meta( 'display_name', $post->post_author ),
				'Date'   => \get_the_date(),
				'URL'    => \get_the_permalink(),
			);

			/**
			 * Lets developers change the Markdown meta headers returned with
			 * the document.
			 * 
			 * @param array    $metadata Markdown document meta headers.
			 * @param \WP_Post $post Exported post.
			 */
			$metadata = \apply_filters( 'markdown_metadata', $metadata, $post );

			$header = '';

			foreach ( $metadata as $key => $value ) {
				$header .= "$key: $value  \n";
			}

			if ( count( $metadata ) ) {
				echo \goblindegook\delimiter_align( $header, ':' );
				echo "\n";
			}

			echo $post->post_content;
			exit;
		}
	}

}
