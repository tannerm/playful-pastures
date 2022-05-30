<?php

/**
 * @class FLCtaModule
 */
class FLCtaModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'          	=> __( 'Call to Action', 'fl-builder' ),
			'description'   	=> __( 'Display a heading, subheading and a button.', 'fl-builder' ),
			'category'      	=> __( 'Actions', 'fl-builder' ),
			'partial_refresh'	=> true,
			'icon'				=> 'megaphone.svg',
		));
	}

	/**
	 * @method get_classname
	 */
	public function get_classname() {
		$classname = 'fl-cta-wrap fl-cta-' . $this->settings->layout;

		if ( 'stacked' == $this->settings->layout ) {
			$classname .= ' fl-cta-' . $this->settings->alignment;
		}

		return $classname;
	}

	/**
	 * @method render_button
	 */
	public function render_button() {
		$btn_settings = array(
			'button_style'     => $this->settings->button_style,
			'button_size'      => $this->settings->button_size,
			'button_width'     => $this->settings->button_width,
			'button_color'     => $this->settings->button_color,
			'button_text'      => $this->settings->button_text,
			'align'            => '',
			'bg_color'         => '',
			'bg_hover_color'   => '',
			'bg_opacity'       => '',
			'border_radius'    => '',
			'border_size'      => '',
			'font_size'        => '',
			'icon'             => $this->settings->btn_icon,
			'icon_position'    => $this->settings->btn_icon_position,
			'icon_animation'   => $this->settings->btn_icon_animation,
			'link'             => $this->settings->btn_link,
			'link_nofollow'    => $this->settings->btn_link_nofollow,
			'link_target'      => $this->settings->btn_link_target,
			'padding'          => '',
			'style'            => '',
			'text'             => $this->settings->btn_text,
			'text_color'       => '',
			'text_hover_color' => '',
			'width'            => 'stacked' == $this->settings->layout ? 'auto' : 'full',
		);

		FLBuilder::render_module_html( 'button', $btn_settings );
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLCtaModule', array(
	'general'       => array(
		'title'         => __( 'General', 'fl-builder' ),
		'sections'      => array(
			'title'         => array(
				'title'         => '',
				'fields'        => array(
					'title'         => array(
						'type'          => 'text',
						'label'         => __( 'Heading', 'fl-builder' ),
						'default'       => __( 'Ready to find out more?', 'fl-builder' ),
						'preview'       => array(
							'type'          => 'text',
							'selector'      => '.fl-cta-title',
						),
						'connections'   => array( 'string' ),
					),
				),
			),
			'text'          => array(
				'title'         => __( 'Text', 'fl-builder' ),
				'fields'        => array(
					'text'          => array(
						'type'          => 'editor',
						'label'         => '',
						'media_buttons' => false,
						'wpautop'		=> false,
						'default'       => __( 'Drop us a line today for a free quote!', 'fl-builder' ),
						'preview'       => array(
							'type'          => 'text',
							'selector'      => '.fl-cta-text-content',
						),
						'connections'   => array( 'string' ),
					),
				),
			),
		),
	),
	'style'        => array(
		'title'         => __( 'Style', 'fl-builder' ),
		'sections'      => array(
			'structure'     => array(
				'title'         => __( 'Structure', 'fl-builder' ),
				'fields'        => array(
					'layout'        => array(
						'type'          => 'select',
						'label'         => __( 'Layout', 'fl-builder' ),
						'default'       => 'inline',
						'options'       => array(
							'inline'        => __( 'Inline', 'fl-builder' ),
							'stacked'       => __( 'Stacked', 'fl-builder' ),
						),
						'toggle'        => array(
							'stacked'       => array(
								'fields'        => array( 'alignment' ),
							),
						),
					),
					'alignment'     => array(
						'type'          => 'select',
						'label'         => __( 'Alignment', 'fl-builder' ),
						'default'       => 'center',
						'options'       => array(
							'left'      => __( 'Left', 'fl-builder' ),
							'center'    => __( 'Center', 'fl-builder' ),
							'right'     => __( 'Right', 'fl-builder' ),
						),
					),
					'spacing'       => array(
						'type'          => 'text',
						'label'         => __( 'Spacing', 'fl-builder' ),
						'default'       => '0',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.fl-module-content',
							'property'      => 'padding',
							'unit'          => 'px',
						),
					),
				),
			),
			'title_structure' => array(
				'title'         => __( 'Heading Structure', 'fl-builder' ),
				'fields'        => array(
					'title_tag'     => array(
						'type'          => 'select',
						'label'         => __( 'Heading Tag', 'fl-builder' ),
						'default'       => 'h3',
						'options'       => array(
							'h1'            => 'h1',
							'h2'            => 'h2',
							'h3'            => 'h3',
							'h4'            => 'h4',
							'h5'            => 'h5',
							'h6'            => 'h6',
						),
					),
					'title_size'    => array(
						'type'          => 'select',
						'label'         => __( 'Heading Size', 'fl-builder' ),
						'default'       => 'default',
						'options'       => array(
							'default'       => __( 'Default', 'fl-builder' ),
							'custom'        => __( 'Custom', 'fl-builder' ),
						),
						'toggle'        => array(
							'custom'        => array(
								'fields'        => array( 'title_custom_size' ),
							),
						),
					),
					'title_custom_size' => array(
						'type'              => 'text',
						'label'             => __( 'Heading Custom Size', 'fl-builder' ),
						'default'           => '24',
						'maxlength'         => '3',
						'size'              => '4',
						'description'       => 'px',
					),
				),
			),
			'colors'        => array(
				'title'         => __( 'Colors', 'fl-builder' ),
				'fields'        => array(
					'text_color'    => array(
						'type'          => 'color',
						'label'         => __( 'Text Color', 'fl-builder' ),
						'default'       => '',
						'show_reset'    => true,
					),
					'bg_color'      => array(
						'type'          => 'color',
						'label'         => __( 'Background Color', 'fl-builder' ),
						'default'       => '',
						'show_reset'    => true,
					),
					'bg_opacity'    => array(
						'type'          => 'text',
						'label'         => __( 'Background Opacity', 'fl-builder' ),
						'default'       => '100',
						'description'   => '%',
						'maxlength'     => '3',
						'size'          => '5',
					),
				),
			),
		),
	),
	'button'        => array(
		'title'         => __( 'Button', 'fl-builder' ),
		'sections'      => array(
			'btn_text'      => array(
				'title'         => '',
				'fields'        => array(
					'btn_text'      => array(
						'type'          => 'text',
						'label'         => __( 'Text', 'fl-builder' ),
						'default'       => __( 'Click Here', 'fl-builder' ),
						'preview'         => array(
							'type'            => 'text',
							'selector'        => '.fl-button-text',
						),
						'connections'   => array( 'string' ),
					),
					'btn_icon'      => array(
						'type'          => 'icon',
						'label'         => __( 'Icon', 'fl-builder' ),
						'show_remove'   => true,
					),
					'btn_icon_position' => array(
						'type'          => 'select',
						'label'         => __( 'Icon Position', 'fl-builder' ),
						'default'       => 'before',
						'options'       => array(
							'before'        => __( 'Before Text', 'fl-builder' ),
							'after'         => __( 'After Text', 'fl-builder' ),
						),
					),
					'btn_icon_animation' => array(
						'type'          => 'select',
						'label'         => __( 'Icon Visibility', 'fl-builder' ),
						'default'       => 'disable',
						'options'       => array(
							'disable'        => __( 'Always Visible', 'fl-builder' ),
							'enable'         => __( 'Fade In On Hover', 'fl-builder' ),
						),
					),
				),
			),
			'btn_link'      => array(
				'title'         => __( 'Button Link', 'fl-builder' ),
				'fields'        => array(
					'btn_link'      => array(
						'type'          => 'link',
						'label'         => __( 'Link', 'fl-builder' ),
						'preview'       => array(
							'type'          => 'none',
						),
						'connections'   => array( 'url' ),
					),
					'btn_link_target' => array(
						'type'          => 'select',
						'label'         => __( 'Link Target', 'fl-builder' ),
						'default'       => '_self',
						'options'       => array(
							'_self'         => __( 'Same Window', 'fl-builder' ),
							'_blank'        => __( 'New Window', 'fl-builder' ),
						),
						'preview'       => array(
							'type'          => 'none',
						),
					),
					'btn_link_nofollow' => array(
						'type'          	=> 'select',
						'label' 	        => __( 'Link No Follow', 'fl-builder' ),
						'default'       => 'no',
						'options' 			=> array(
							'yes' 				=> __( 'Yes', 'fl-builder' ),
							'no' 				=> __( 'No', 'fl-builder' ),
						),
						'preview'       	=> array(
							'type'          	=> 'none',
						),
					),
				),
			),
			'btn_style'     => array(
				'title'  => __( 'Button Style', 'fl-builder' ),
				'fields' => Church\Integrations\BB::get_button_fields(),
			),
		),
	),
));
