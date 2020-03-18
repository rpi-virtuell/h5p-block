<?php
/**
 * H5P Block
 *
 * @author    Frank Neumann-Staude <frank@staude.net>
 * @license   GPL2
 * @link      https://staude.net
 * @copyright 2020 Frank Neumann-Staude
 *
 * Plugin Name:       H5P-Block
 * Plugin URI:        https://staude.net
 * Description:       Create an Gutenberg BLock to insert h5p content from library
 * Version:           1.0.0
 * Author:            Frank Neumann-Staude
 * Author URI:        https://staude.net
 * Text Domain:       h5p-block
 * License:           GPL2
 * License URI:       https://opensource.org/licenses/GPL-2.0
 * Domain Path:       /languages
 */

function register_acf_block_types() {

	// register a testimonial block.
	acf_register_block_type(array(
		'name'              => 'h5p-block',
		'title'             => __('H5P Content'),
		'description'       => __('Insert h5p content.'),
		'render_template'   => plugin_dir_path( __FILE__ ) . 'template-parts/blocks/h5p-block/h5p-block.php',
		'category'          => 'common',
		'icon'              => 'book-alt',
		'keywords'          => array( 'interactive', 'content', 'h5p' ),
	));

	if( function_exists('acf_add_local_field_group') ):

		$h5p_content = array();
		global $wpdb;
		$files = $wpdb->get_results($wpdb->prepare(
			"SELECT id, title 
           FROM {$wpdb->prefix}h5p_contents
          WHERE disable = 0" )
		);
		foreach ($files as $file) {
			$h5p_content[$file->id] = $file->title;
		}
		acf_add_local_field_group(array(
			'key' => 'group_5e6e35d60db31',
			'title' => 'Block: h5p',
			'fields' => array(
				array(
					'key' => 'field_5e6e360f8da77',
					'label' => 'H5P Inhalt',
					'name' => 'h5p_inhalt',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => $h5p_content,
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 1,
					'ajax' => 1,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5e723bd3a4b2c',
					'label' => 'URL Block ausblenden',
					'name' => 'hide_url',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						0 => 'Nein',
						1 => 'Ja',
					),
					'allow_custom' => 0,
					'default_value' => array(
						0,
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'block',
						'operator' => '==',
						'value' => 'acf/h5p-block',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
		));

	endif;
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
	add_action('acf/init', 'register_acf_block_types');
}

function check_h5p_shortlinks() {
	if ( is_404() ) {
		$uri = $_SERVER[ 'REQUEST_URI' ];
		if ( strpos( $uri, '/ru/') !== false ) {
			$temp = (int) substr( $uri, 4 );
			wp_redirect( admin_url() . "admin-ajax.php?action=h5p_embed&id=" . $temp);
			exit;

		}
	}
}
add_filter('template_redirect', 'check_h5p_shortlinks' );


function register_frontend_plugin_styles() {
	wp_enqueue_script( 'rw-h5pblock-js',  plugin_dir_url( __FILE__ ) . 'js/h5pblock.js' );
	wp_enqueue_script( 'rw-resizer-h5pblock-js',  plugin_dir_url( __FILE__ ) . '../h5p/h5p-php-library/js/h5p-resizer.js' );
}
add_action('wp_enqueue_scripts','register_frontend_plugin_styles' );

function register_admin_plugin_styles() {
	wp_enqueue_script( 'rw-resizer-h5pblock-js',  plugin_dir_url( __FILE__ ) . '../h5p/h5p-php-library/js/h5p-resizer.js' );
}
add_action('admin_enqueue_scripts','register_admin_plugin_styles' );

