<!--<div class="<?php echo $module->get_classname(); ?>">
	<?php if ( isset( $settings->click_action ) && 'lightbox' == $settings->click_action ) : ?>
		<a href="<?php echo 'video' == $settings->lightbox_content_type ? $settings->lightbox_video_link : '#'; ?>" class="fl-button fl-button-lightbox<?php if ( 'enable' == $settings->icon_animation ) : ?> fl-button-icon-animation<?php endif; ?>" role="button">
	<?php else : ?>
			<a href="<?php echo $settings->link; ?>" target="<?php echo $settings->link_target; ?>" class="fl-button<?php if ( 'enable' == $settings->icon_animation ) : ?> fl-button-icon-animation<?php endif; ?>" role="button"<?php echo $module->get_rel(); ?>>
	<?php endif; ?>
		<?php if ( ! empty( $settings->icon ) && ( 'before' == $settings->icon_position || ! isset( $settings->icon_position ) ) ) : ?>
		<i class="fl-button-icon fl-button-icon-before fa <?php echo $settings->icon; ?>"></i>
		<?php endif; ?>
		<?php if ( ! empty( $settings->text ) ) : ?>
		<span class="fl-button-text"><?php echo $settings->text; ?></span>
		<?php endif; ?>
		<?php if ( ! empty( $settings->icon ) && 'after' == $settings->icon_position ) : ?>
		<i class="fl-button-icon fl-button-icon-after fa <?php echo $settings->icon; ?>"></i>
		<?php endif; ?>
	</a>
</div>
<?php if ( 'lightbox' == $settings->click_action && 'html' == $settings->lightbox_content_type && isset( $settings->lightbox_content_html ) ) : ?>
	<div class="fl-node-<?php echo $id; ?> fl-button-lightbox-content mfp-hide">
		<?php echo $settings->lightbox_content_html; ?>
	</div>
<?php endif; ?>
-->

<div class="<?php echo $module->get_classname(); ?>">

	<?php
		$button_classes = 'fl-button ';

		if ( 'enable' == $settings->icon_animation ) {
			$button_classes .= 'fl-button-icon-animation ';
		}

		$button_classes .= $settings->button_style . ' ' . $settings->button_size . ' ' . $settings->button_color . ' ' . $settings->button_text;
		
		// $button_width is no longer used
		if ( 'full' === $settings->width || 'is-fullwidth' === $settings->button_width ) {
			$button_classes .= ' is-fullwidth';
		}
	?>

	<a href="<?php echo $settings->link; ?>"
	   target="<?php echo $settings->link_target; ?>"
	   class="<?php echo $button_classes; ?>"
	   role="button"<?php echo $module->get_rel(); ?>>

		<?php if ( ! empty( $settings->icon ) && ( 'before' == $settings->icon_position || ! isset( $settings->icon_position ) ) ) : ?>
			<i class="fl-button-icon fl-button-icon-before fa <?php echo $settings->icon; ?>"></i>
		<?php endif; ?>
		<?php if ( ! empty( $settings->text ) ) : ?>
			<span class="fl-button-text"><?php echo $settings->text; ?></span>
		<?php endif; ?>
		<?php if ( ! empty( $settings->icon ) && 'after' == $settings->icon_position ) : ?>
			<i class="fl-button-icon fl-button-icon-after fa <?php echo $settings->icon; ?>"></i>
		<?php endif; ?>
	</a>
</div>
