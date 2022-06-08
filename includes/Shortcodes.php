<?php

namespace Church;

/**
 * Provides the global $arms_directory object
 *
 * @author tanner moushey
 */
class Shortcodes {

	/**
	 * @var
	 */
	protected static $_instance;

	/**
	 * Only make one instance of Shortcodes
	 *
	 * @return Shortcodes
	 */
	public static function get_instance() {
		if ( ! self::$_instance instanceof Shortcodes ) {
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
		add_shortcode( 'cp-location-header', [ $this, 'location_header_cb' ] );
	}

	/** Actions **************************************/

	public function location_header_cb() {
		if ( ! $location_id = get_query_var( 'cp_location_id' ) ) {
			return '';
		}
		
		return sprintf( '<a href="%s" class="cp-location-header">%s</a>', get_permalink( $location_id ), get_the_title( $location_id ) );
	}
}