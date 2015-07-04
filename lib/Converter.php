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
	 * Markdown converter instance.
	 * @var \Parsedown
	 */
	private $converter;

	/**
	 * Converter constructor.
	 * @param Plugin     $plugin    Plugin instance.
	 * @param \Parsedown $converter Markdown converter instance.
	 */
	public function __construct( Plugin $plugin, \Parsedown $converter ) {
		$this->plugin    = $plugin;
		$this->converter = $converter;
	}

    /**
     * Wrapper method for the Parsedown formatter.
     *
     * @param  string $text Markdown-formatted text.
     * 
     * @return string       Converted HTML.
     */
    public function convert( $text ) {
        return $this->converter->text($text);
    }

    /**
     * Wraps a string in paragraph tags.
     *
     * @param  string $text String to wrap.
     * 
     * @return string       Paragraph-wrapped string.
     */
    public function add_p( $text ) {
        if ( preg_match( '{^$|^<(p|ul|ol|dl|pre|blockquote|div)>}i', $text ) ) {
        	return $text;
        }

        $text = '<p>' . $text . '</p>';
        $text = preg_replace( '{\n{2,}}', "</p>\n\n<p>", $text );

        return $text;
    }

    /**
     * Remove paragraph tags.
     *
     * @param  string $text String with paragraph tags.
     * 
     * @return string       Gone! Magic!
     */
    public function strip_p( $text ) {
        return preg_replace( '{</?p>}i', '', $text );
    }

}
