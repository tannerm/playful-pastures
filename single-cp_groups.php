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
<section class="right-con">
	<?php if ( has_post_thumbnail( $post->ID ) ): ?>
		  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
		  <img id="custom-bg" src="<?php echo $image[0]; ?>">
	<?php endif; ?>
	<?php 
		$location = get_post_meta( $post->ID, 'location', true );
		// Check if the custom field has a value.
		if ( ! empty( $location ) ) { ?>
			<div class="location">
		    	<?php echo $location; ?>
		    </div>
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
		    	<?php echo do_shortcode( $sign_up_form ); ?>
		    </div>
		<?php } ?>
</section>

<?php get_footer(); ?>
