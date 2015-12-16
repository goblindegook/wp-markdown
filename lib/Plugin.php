<?php

namespace goblindegook\WP\Markdown;

class Plugin {

	/**
	 * Plugin name.
	 * @var string
	 */
	private $name = '';

	/**
	 * Plugin version.
	 * @var string
	 */
	private $version = '';

	/**
	 * Converter instance.
	 * @var Converter
	 */
	private $converter;

	/**
	 * Exporter instance.
	 * @var Exporter
	 */
	private $exporter;

	/**
	 * Plugin constructor.
	 * @param string $name    Plugin name.
	 * @param string $version Plugin version.
	 */
	public function __construct( $name, $version ) {
		$this->name      = $name;
		$this->version   = $version;
		$this->converter = new Converter( $this, new \ParsedownExtra() );
		$this->exporter  = new Exporter( $this );
	}

	/**
	 * Plugin loader.
	 */
	public function run() {
		\add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		\add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		$this->setup_content_hooks();
		$this->setup_excerpt_hooks();
		$this->setup_comment_hooks();
		$this->setup_widget_hooks();
		$this->setup_exporter();
	}

	/**
	 * Enqueue frontend styles.
	 */
	public function styles() {
		\wp_enqueue_style( $this->get_name() . '-prism',
			\plugins_url( 'css/prism.css', __DIR__ ),
			array(),
			$this->get_version() );
	}

	/**
	 * Enqueue frontend scripts.
	 */
	public function scripts() {
		\wp_enqueue_script( $this->get_name() . '-prism',
			\plugins_url( 'js/prism.js', __DIR__ ),
			array(),
			$this->get_version(),
			true );
	}

	/**
	 * Plugin name getter.
	 * @return string Plugin name.
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Plugin version getter.
	 * @return string Plugin version.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Add and adjust content parsing hooks.
	 *
	 * @global $wp_embed WP Embed instance.
	 */
	private function setup_content_hooks() {

		// Stop WordPress from automatically adding paragraphs:
		\remove_filter( 'the_content',     'wpautop' );
		\remove_filter( 'the_content_rss', 'wpautop' );

		// Rebalance tags on display rather than when saving:
		\remove_filter( 'content_save_pre', 'balanceTags', 50 );
		\add_filter( 'the_content', 'balanceTags', 50 );

		// Reschedule texturization:
		\remove_filter( 'the_content', 'wptexturize', 10 );
		\add_filter( 'the_content', 'wptexturize', 20 );

		// Convert content from Markdown:
		\add_filter( 'the_content',     array( $this->converter, 'convert' ) );
		\add_filter( 'the_content',     array( $this->converter, 'unquote' ) );
		\add_filter( 'the_content_rss', array( $this->converter, 'convert' ) );
		\add_filter( 'the_content_rss', 'wp_strip_all_tags' );
	}

	/**
	 * Add and adjust excerpt parsing hooks.
	 */
	private function setup_excerpt_hooks() {
		// Stop WordPress from automatically adding paragraphs:
		\remove_filter( 'the_excerpt', 'wpautop' );

		// Rebalance tags on display rather than when saving:
		\remove_filter( 'excerpt_save_pre', 'balanceTags', 50 );
		\add_filter( 'get_the_excerpt', 'balanceTags', 9 );

		// Convert excerpts from Markdown:
		\add_filter( 'get_the_excerpt', array( $this->converter, 'convert' ), 6 );
		\add_filter( 'get_the_excerpt', array( $this->converter, 'unquote' ), 6 );
		\add_filter( 'get_the_excerpt', 'trim', 7 );
		\add_filter( 'the_excerpt',     'wpautop' );
		\add_filter( 'the_excerpt_rss', 'wp_strip_all_tags' );
	}

	/**
	 * Add and adjust comment parsing hooks.
	 */
	private function setup_comment_hooks() {
		// Stop WordPress from automatically adding paragraphs to comments:
		\remove_filter( 'comment_text', 'wpautop' );
		\remove_filter( 'comment_text', 'make_clickable' );

		// Convert comments from Markdown:
		\add_filter( 'comment_text',        array( $this->converter, 'convert' ), 6 );
		\add_filter( 'comment_text',        array( $this->converter, 'unquote' ), 6 );
		\add_filter( 'get_comment_text',    array( $this->converter, 'convert' ), 6 );
		\add_filter( 'get_comment_excerpt', array( $this->converter, 'convert' ), 6 );
		\add_filter( 'get_comment_excerpt', 'wp_strip_all_tags',                  7 );		
	}

	/**
	 * Parse Markdown content in widgets.
	 */
	private function setup_widget_hooks() {
		\add_filter( 'widget_text', array( $this->converter, 'convert' ) );
	}

	/**
	 * Setup exporter.
	 */
	private function setup_exporter() {
		\add_filter( 'query_vars', array( $this->exporter, 'filter_query_vars' ) );
		\add_filter( 'post_rewrite_rules', array( $this->exporter, 'filter_rewrite_rules' ) );
		\add_filter( 'page_rewrite_rules', array( $this->exporter, 'filter_rewrite_rules' ) );
		\add_action( 'template_redirect', array( $this->exporter, 'text' ) );
	}

}
