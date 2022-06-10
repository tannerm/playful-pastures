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
		add_shortcode( 'cp-location-dropdown', [ $this, 'location_dropdown_cb' ] );
	}

	/** Actions **************************************/

	public function location_header_cb() {
		if ( ! $location_id = get_query_var( 'cp_location_id' ) ) {
			return '';
		}
		
		return sprintf( '<a href="%s" class="cp-location-header">%s</a>', get_permalink( $location_id ), get_the_title( $location_id ) );
	}
	
	public function location_dropdown_cb() {
		if ( ! class_exists( 'CP_Locations\Models\Location' ) ) {
			return '';
		}
		
		$location_id = get_query_var( 'cp_location_id' );
		
		$locations = \CP_Locations\Models\Location::get_all_locations();
		
		ob_start(); ?>

		<select class="cp-location-dropdown button-dropdown">
			<option value=""><?php _e( 'Select a Location', 'cp-theme-default'); ?></option>
			<?php foreach( $locations as $location ) : ?>
				<option value="<?php echo get_permalink( $location->origin_id ); ?>" <?php selected( $location_id, $location->origin_id ); ?>><?php echo get_the_title( $location->origin_id ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php
		add_action( 'wp_footer', [ $this, 'location_select_js' ] );
		return ob_get_clean();
	}
	
	public function location_select_js() {
		?>
		<script>
			jQuery('.cp-location-dropdown').on('change', function(e) {
				if (jQuery(e.target).val()) {
					window.location = jQuery(e.target).val();
				}
			})
		</script>
		<?php
	}
}