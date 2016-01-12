<?php

namespace goblindegook\WP\Markdown;

/**
 * Markdown converter.
 */
class Converter {

	/**
	 * Plugin instance.
	 * @var Plugin
	 */
	private $plugin;

	/**
	 * Markdown parser instance.
	 * @var \Parsedown
	 */
	private $parser;

	/**
	 * Converter constructor.
	 * @param Plugin     $plugin Plugin instance.
	 * @param \Parsedown $parser Markdown parser instance.
	 */
	public function __construct( Plugin $plugin, \Parsedown $parser ) {
		$this->plugin = $plugin;
		$this->parser = $parser;
	}

    /**
     * Wrapper method for the Parsedown formatter.
     *
     * @param  string $text Markdown-formatted text.
     * 
     * @return string       Converted HTML.
     */
    public function convert( $text ) {
        $key  = hash( 'sha256', $text );
        $html = \wp_cache_get( $key, 'wp-markdown' );

        if ( $html === false ) {
            $html = $this->parser->text( $text );
            \wp_cache_set( $key, $html, 'wp-markdown', 24 * 60 * 60 );
        }

        return $html;
    }

	/**
	 * Remove HTML quote entities, allowing wptexturize() to replace them with
	 * curly quotes.
	 * 
	 * @param  string $text HTML with &quot; entities.
	 * 
	 * @return string       HTML without &quot; entities.
	 */
	public function unquote( $text ) {
		return str_replace( '&quot;', '"', $text );
	}

}
