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
        return $this->parser->text($text);
    }

}
