<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>
<div class="groups-listing">
	<section class="title">
		<h1 class="page-title ast-archive-title">
			<?php _e('Groups');?>
		</h1>
	</section>
	<section class="search">
		<form action="" method="post" id="grp-filter">
			<div class="search-form-field">
				<select id="meeting-day" name="meeting_day">
					<option value="">Meeting Day</option>
					<option value="Monday" <?php if( $_POST['meeting_day'] == 'Monday' ) { echo 'selected';}?>>Monday</option>
					<option value="Tuesday" <?php if( $_POST['meeting_day'] == 'Tuesday' ) { echo 'selected';}?>>Tuesday</option>
					<option value="Wednesday" <?php if( $_POST['meeting_day'] == 'Wednesday' ) { echo 'selected';}?>>Wednesday</option>
					<option value="Thursday" <?php if( $_POST['meeting_day'] == 'Thursday' ) { echo 'selected';}?> >Thursday</option>
					<option value="Friday" <?php if( $_POST['meeting_day'] == 'Friday' ) { echo 'selected';}?> >Friday</option>
					<option value="Saturday" <?php if( $_POST['meeting_day'] == 'Saturday' ) { echo 'selected';}?> >Saturday</option>
					<option value="Sunday" <?php if( $_POST['meeting_day'] == 'Sunday' ) { echo 'selected';}?> >Sunday</option>
				</select>
			</div>
			<?php $tax_terms = get_terms('cp_groups_categories', array('hide_empty' => false));
				if( $tax_terms ) { ?>
				<div class="search-form-field">
					<select id="cat" name="category">
						<option value="">Category</option>
						<?php foreach ($tax_terms as $tax_term) { ?>
							<option value="<?php echo $tax_term->slug;?>" <?php if( $_POST['category'] == $tax_term->slug ) { echo 'selected';}?>><?php echo $tax_term->name;?></option>
						<?php } ?>
					</select>
				</div>
			<?php } ?>
			<div class="search-form-field child-care-input">
				<input type="checkbox" name="child_care" <?php if( $_POST['child_care'] == 'on' ) { echo 'checked';}?> ><label class="label-chid-care">Child Care</label>
			</div>
			<div class="search-form-field">
				<input type="submit" class="search-btn" id="submit" name="submit" value="Search">
			</div>
		</form>
	</section>
	<section class="map">
		<div id = "maplist" style = "width:100%; height:200px"></div>
	</section>
	<section class="posts">
		<?php 
		$tax_query = array();
		$meta_query = array();
		// Verify this came from the our screen and with proper authorization,
		if ( !empty ( $_POST['category'] ) ) {
			$tax_query[] = array(
				        'taxonomy' => 'cp_groups_categories',
			            'field'    => 'slug',
			            'terms'    => $_POST['category'],
			);
		}
		if ( !empty ( $_POST['meeting_day'] ) || !empty ( $_POST['child_care'] ) ) {
		
				$meta_query[] = array(
				        array(
	                        'relation' => 'OR',
	                        array(
					            'key'     => 'meeting_day',
					            'value'   => $_POST['meeting_day'] ,
					            'compare' => '=',
				       		 ),
	                        array(
					            'key'     => 'child_care',
					            'value'   => $_POST['child_care'],
					            'compare' => '=',
				       		 )
						)
				    );

	    }	
	                         
		$args = array(
			'post_type' => 'cp_groups',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'tax_query' =>  $tax_query,
			'meta_query' => $meta_query,
		);

		$query = new WP_Query( $args );
		
		//echo $wpdb->last_query;
		// The Loop
		$locations = array();
		$i = 1;
		if ( $query->have_posts() ) {
		    while ( $query->have_posts() ) {
		        $query->the_post();
		
				$location_lat = get_post_meta( $post->ID, 'location_lat', true );
				$location_long = get_post_meta( $post->ID, 'location_long', true );
				$locations[] = '["LOCATION_'.$i.'", '.$location_lat.', '.$location_long.']';
								
		        ?>
		        <div class="group_post">
		        <?php
				if ( has_post_thumbnail( $post->ID ) ): ?>
					<div class="group-post-image">
				  		<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
				  		<img id="custom-bg" src="<?php echo $image[0]; ?>">
				  	</div>
				<?php endif; ?>
					<div class="group-post-content">
						<h2><?php echo $post->post_title;?></h2>
						<?php if( $post->post_content ) { ?>
							<div class="description">
								<p><?php echo $post->post_content;?></p>
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
						    	<?php echo __( 'Meeting day :' ) . $meeting_day; ?>
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
					    	<?php echo __( 'Child care provided :' ) ?><input type="checkbox" <?php echo $checked;?>>
					    </div>

					    <a href="<?php echo get_permalink();?>">Learn More</a>
					</div>
			</div>
			<?php $i++; }
			
		} else {
		    echo '<h2>No posts found</h2>';
		}
		 
		// Restore original Post Data
		wp_reset_postdata();

		 ?>
	</section>
</div>

<?php get_footer(); ?>
<script type="text/javascript">
	var locations = <?php echo json_encode($locations);?>;
	
	centerarea = JSON.parse(locations[0]);
	
	var map = L.map('maplist').setView([centerarea[1], centerarea[2]], 8);
		mapLink =
		  '<a href="http://openstreetmap.org">OpenStreetMap</a>';
		L.tileLayer(
		  'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		    attribution: '&copy; ' + mapLink + ' Contributors',
		    maxZoom: 5,
		  }).addTo(map);

		for (var i = 0; i < locations.length; i++) {
			//console.log (locations[i]);
			parsedTest = JSON.parse(locations[i]); //an array [1,2]
		  marker = new L.marker([parsedTest[1], parsedTest[2]])
		    .bindPopup(parsedTest[0])
		    .addTo(map);
		}
			
	</script>	
