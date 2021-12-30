<?php

namespace Church;

/**
 * Provides the global $arms_directory object
 *
 * @author tanner moushey
 */
class Init {

	/**
	 * @var
	 */
	protected static $_instance;

	/**
	 * @var \WPackio\Enqueue
	 */
	public $enqueue;

	/**
	 * Only make one instance of Init
	 *
	 * @return Init
	 */
	public static function get_instance() {
		if ( ! self::$_instance instanceof Init ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Class constructor: Add Hooks and Actions
	 *
	 */
	protected function __construct() {
		$this->actions();
	}

	/**
	 * Actions and Filters
	 *
	 * @return void
	 */
	protected function actions() {
		/** API */
		$this->enqueue = new \WPackio\Enqueue( $this->get_id(), 'dist', $this->get_version(), 'theme', false, 'child' );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 9999 );
	}

	/** Actions **************************************/
	public function enqueue_scripts() {
		$this->enqueue->enqueue( 'theme', 'styles', [] );
	}

	/**
	 * Returns the theme name, localized
	 *
	 * @return string the theme name
	 * @since 1.0.0
	 */
	public function get_theme_name() {
		return __( 'cp', 'cp' );
	}

	/**
	 * Provide a unique ID tag for the plugin
	 *
	 * @return string
	 */
	public function get_id() {
		return 'cp';
	}

	/**
	 * The version for this theme
	 * 
	 * @return string
	 * @since  1.0.0
	 *
	 * @author Tanner Moushey
	 */
	public function get_version() {
		return '1.0.0';
	}

	/**
	 * Get the API namespace to use
	 *
	 * @return string
	 * @since  1.0.0
	 *
	 * @author Tanner Moushey
	 */
	public function get_api_namespace() {
		return $this->get_id() . '/v1';
	}

}