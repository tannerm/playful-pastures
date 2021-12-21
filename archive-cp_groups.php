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

<section class="title">
	<h1 class="page-title ast-archive-title">
		<?php _e('Groups');?>
	</h1>
</section>
<section class="search">
	<form action="" method="post" id="grp-filter">
		<select id="meeting-day" name="meeting_day">
			<option value="">Meeting Day</option>
			<option value="monday">Monday</option>
			<option value="tuesday">Tuesday</option>
			<option value="wednesday">Wednesday</option>
			<option value="thursday">Thursday</option>
			<option value="friday">Friday</option>
			<option value="saturday">Saturday</option>
			<option value="sunday">Sunday</option>
		</select>
		<?php $tax_terms = get_terms('cp_groups_categories', array('hide_empty' => false));
			if( $tax_terms ) { ?>
			<select id="cat" name="category">
				<option value="">Category</option>
				<?php foreach ($tax_terms as $tax_term) { ?>
					<option value="<?php echo $tax_term->slug;?>"><?php echo $tax_term->name;?></option>
				<?php } ?>
			</select>
		<?php } ?>
		<input type="checkbox" name="child_care">
		<input type="submit" id="submit" name="submit" value="Search">
	</form>
</section>
<section class="map">
	
</section>
<section class="posts">
	<?php 
	echo '<pre>';
	print_r ($_POST);
	$args = array(
    	'post_type' => 'cp_groups',
	);
	if( isset( $_POST['category'] ) ) {
		$args['tax_query'] = array(
	        array(
	            'taxonomy' => 'cp_groups_categories',
	            'field'    => 'slug',
	            'terms'    => $_POST['category'],
	        ),
    	);
	}
	if( isset( $_POST['meeting_day'] ) ) {
		$args['meta_query'] = array(
	        array(
	            'key'     => 'meeting_day',
	            'value'   => $_POST['meeting_day'] ,
	            'compare' => 'Like',
       		 ),
    	);
	}
	if( isset( $_POST['child_care'] ) ) {
		$args['meta_query'] = array(
			'relation' => 'AND',
	        array(
	            'key'     => 'meeting_day',
	            'value'   => 'on' ,
	            'compare' => 'Like',
       		 ),
    	);
	}
	$custom_posts = new WP_Query( $args );
	if( $custom_posts->have_posts() ) :
    while ($custom_posts->have_posts()) : $custom_posts->the_post(); 
	        echo get_the_title( $post->ID );
	    endwhile;
	endif;
	wp_reset_query($custom_posts);

	foreach( $posts as $post ) {
		if ( has_post_thumbnail( $post->ID ) ): ?>
		  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
		  <img id="custom-bg" src="<?php echo $image[0]; ?>">
		<?php endif; ?>
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
		$location = get_post_meta( $post->ID, 'location', true );
		// Check if the custom field has a value.
		if ( ! empty( $location ) ) { ?>
			<div class="location">
		    	<?php echo $location; ?>
		    </div>
		<?php } ?>

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
	<?php } ?>
</section>

<?php get_footer(); ?>
