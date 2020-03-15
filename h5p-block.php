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
		'description'       => __('A custom testimonial block.'),
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

function my_h5p_acf_load_value( $value, $post_id, $field ) {


	return $value;
}

// Apply to all fields.
//add_filter('acf/load_value/key=field_5e6e360f8da77', 'my_h5p_acf_load_value', 1, 3);
