<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Astra
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header(); ?>
<div class="group-detail">
	<section class="right-con">
	<?php if ( has_post_thumbnail( $post->ID ) ): ?>
		  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
		  <img id="custom-bg" src="<?php echo $image[0]; ?>">
	<?php endif; ?>
	<?php 
		$location_lat = get_post_meta( $post->ID, 'location_lat', true );
		$location_long = get_post_meta( $post->ID, 'location_long', true );
		if ( ! empty( $location_long ) || ! empty( $location_lat ) ) { ?>
			<div id = "map" style = "width:200PX; height:200px"></div>
		<?php } ?>
	</section>
	<section class="posts left-con">
			<h2><?php echo $post->post_title;?></h2>
			<?php if( $post->post_content ) { ?>
				<div class="description">
					<?php __( 'Group description' );?>
					<p><?php echo $post->post_content	;?></p>
				</div>
			<?php } ?>
			<div class="category">
				<?php $post_categories = get_the_terms( $post->ID, 'cp_groups_categories' );
				foreach( $post_categories as $cd ){
					echo $cd->name;
				} ?>
			</div>

			<?php 
			$meeting_day = get_post_meta( $post->ID, 'meeting_day', true );
			// Check if the custom field has a value.
			if ( ! empty( $meeting_day ) ) { ?>
				<div class="meeting_day">
			    	<?php echo __( 'Meeting day : ' ) . $meeting_day; ?>
			    </div>
			<?php } ?>

			<?php 
			$child_care = get_post_meta( $post->ID, 'child_care', true );

			// Check if the custom field has a value.
			if ( $child_care == 'on' ) {
				$checked = 'Checked';
			}
			else {
				$checked = '';
			} ?>
			<div class="child_care">
		    	<?php echo __( 'Child care provided : ' ) ?><input type="checkbox" <?php echo $checked;?>>
		    </div>

			<?php 
			$enrollment_status = get_post_meta( $post->ID, 'enrollment_status', true );
			if ( $enrollment_status == 'on' ) {
				$checked = 'Checked';
			}
			else {
				$checked = '';
			} ?>
			<div class="enrollment_status">
		    	<?php echo __( 'Enrollment status : ' ) ?><input type="checkbox" <?php echo $checked;?>>
		    </div>

			
			<?php $sign_up_form = get_post_meta( $post->ID, 'sign_up_form', true );
			// Check if the custom field has a value.
			if ( ! empty( $sign_up_form ) ) { ?>
				<div class="sign_up_form">
			    	<?php echo do_shortcode( '[gravityform id="'.$sign_up_form.'"]' ); ?>
			    </div>
			<?php } ?>
	</section>
</div>
<script type="text/javascript">
	var maptarget;
	var map;
	var panorama;
	//google.maps.event.addDomListener(window, 'load', initialize);

									
	jQuery(function($){ 	
		window.addEventListener('load', initialize_yoart)					
		
	});

	function initialize_yoart() 
	{
		var long = <?php echo $location_long;?>;
		var lat = <?php echo $location_lat;?>;

		maptarget= new L.LatLng(long, lat);
		var mapOptions = {
			center: maptarget,
			zoom: 10,
		};
		var map = L.map('map').setView(mapOptions.center, mapOptions.zoom);
		
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 18,
		attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
		}).addTo(map);
		map.scrollWheelZoom.disable(); 
			
			var marker = L.marker(mapOptions.center);    // Creating a Marker
     
	         // Adding popup to the marker
	         marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
	         marker.addTo(map); 
	}				
</script>		
<?php get_footer(); ?>
