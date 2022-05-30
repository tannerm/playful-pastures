<div class="<?php echo $module->get_classname(); ?>">
	<?php
	/**
	 * @global $settings
	 **/

	// Image left
	$module->render_image( 'left' );

	?>
	<div class="fl-callout-content">
		<?php

		// Image above title
		if ( $settings->icon_bg_color && 'above-title' == $settings->photo_position ) : ?>
			<div class="fl-icon-wrapper-bg" style="background-color: #<?php echo $settings->icon_bg_color; ?>;">
				<?php $module->render_image( 'above-title' ); ?>
			</div>
		<?php else : ?>
			<?php $module->render_image( 'above-title' ); ?>
		<?php endif;

		// Title
		$module->render_title();

		// Image below title
		$module->render_image( 'below-title' );

		?>
		<div class="fl-callout-text-wrap">
			<?php

			// Text
			$module->render_text();

			// Link CTA
			$module->render_link();

			// Button CTA
			$module->render_button();

			?>
		</div>
	</div>
	<?php

	// Image right
	$module->render_image( 'right' );

	?>
</div>
