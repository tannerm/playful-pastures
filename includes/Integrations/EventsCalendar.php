<?php

namespace Church\Integrations;

/**
 * Provides the global $arms_directory object
 *
 * @author tanner moushey
 */
class EventsCalendar {

	/**
	 * @var string 
	 */
	public static $_ministry_tax = 'cp_ministry';
	
	/**
	 * @var
	 */
	protected static $_instance;

	/**
	 * Only make one instance of EventsCalendar
	 *
	 * @return EventsCalendar
	 */
	public static function get_instance() {
		if ( ! self::$_instance instanceof EventsCalendar ) {
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
		add_filter( 'tribe_events_pro_inline_placeholders', [ $this, 'inline_placeholders' ] );
		add_action( 'init', [ $this, 'register_ministry_tax' ], 999 );
	}

	/** Actions **************************************/

	public function inline_placeholders( $placeholders ) {
		$placeholders['{campus}'] = [ $this, 'event_campus' ];
		$placeholders['{ministry}'] = [ $this, 'event_ministry' ];
		$placeholders['{date_flag}'] = [ $this, 'date_flag' ];
		
		return $placeholders;
	}

	/**
	 * Return the campuses for this ministry
	 * 
	 * @param $id
	 *
	 * @return string
	 * @since  1.0.0
	 *
	 * @author Tanner Moushey
	 */
	public function event_campus( $id ) {
		if ( ! function_exists( 'cp_locations' ) ) {
			return '';
		}
		
		$tax = cp_locations()->setup->taxonomies->location->taxonomy;
		
		$terms = wp_get_object_terms( $id, $tax, [ 'fields' => 'names' ] );
		
		if ( ! is_array( $terms ) ) {
			return '';
		}
		
		return implode( ', ', $terms );
	}

	/**
	 * Return the categories associated with this event
	 * 
	 * @param $id
	 *
	 * @return string
	 * @since  1.0.0
	 *
	 * @author Tanner Moushey
	 */
	public function event_ministry( $id ) {
		$tax = self::$_ministry_tax;
		
		$terms = wp_get_object_terms( $id, $tax, [ 'fields' => 'names' ] );
		
		if ( ! is_array( $terms ) ) {
			return '';
		}
		
		return implode( ', ', $terms );		
	}

	/**
	 * Add a date flag
	 * 
	 * @param $id
	 *
	 * @return string
	 * @since  1.0.0
	 *
	 * @author Tanner Moushey
	 */
	public function date_flag( $id ) {
		$month = tribe_get_start_date( $id, false, 'M' );
		$day = tribe_get_start_date( $id, false, 'd' );
		
		if ( ! $month ) {
			return '';
		}
		
		return sprintf( '<div class="date-flag"><div class="h5">%s</div><div class="h3">%s</div></div>', strtoupper( $month ), $day );
	}

	/**
	 * Register the ministry taxonomy
	 * 
	 * @since  1.0.0
	 *
	 * @author Tanner Moushey
	 */
	public function register_ministry_tax() {
		$plural_label = 'Ministries';
		$single_label = 'Ministry';
		
		$labels = array(
			'name'                       => $plural_label,
			'singular_name'              => $single_label,
			'search_items'               => sprintf( __( 'Search %s', 'cp-library' ), $plural_label ),
			'popular_items'              => sprintf( __( 'Popular %s', 'cp-library' ), $plural_label ),
			'all_items'                  => sprintf( __( 'All %s', 'cp-library' ), $plural_label ),
			'edit_item'                  => sprintf( __( 'Edit %s', 'cp-library' ), $single_label ),
			'update_item'                => sprintf( __( 'Update %s', 'cp-library' ), $single_label ),
			'add_new_item'               => sprintf( __( 'Add New %s', 'cp-library' ), $single_label ),
			'new_item_name'              => sprintf( __( 'New %s Name', 'cp-library' ), $single_label ),
			'separate_items_with_commas' => sprintf( __( 'Separate %s with commas', 'cp-library' ), strtolower( $plural_label ) ),
			'add_or_remove_items'        => sprintf( __( 'Add or remove %s', 'cp-library' ), strtolower( $plural_label ) ),
			'choose_from_most_used'      => sprintf( __( 'Choose from the most used %s', 'cp-library' ), strtolower( $plural_label ) ),
			'not_found'                  => sprintf( __( 'No %s found.', 'cp-library' ), strtolower( $plural_label ) ),
			'menu_name'                  => $plural_label,
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => strtolower( $plural_label ) ),
		);
		
		register_taxonomy( self::$_ministry_tax, 'tribe_events', $args );
	}
	
}