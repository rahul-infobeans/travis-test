<?php
/**
 * Plugin Name: Test Block
 * Description: Test plugin to check block editor
 * Author: Rahul N
 * Version: 1.0.1
 */

add_action( 'enqueue_block_editor_assets', 'gb_block_01_basic_editor_assets' );

function gb_block_01_basic_editor_assets() {
	// Scripts.
	wp_enqueue_script(
		'gb-block-01-basic',
		plugins_url( 'block.js', __FILE__ ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'block.js' )
	);

	// Styles.
	wp_enqueue_style(
		'gb-block-01-basic-editor',
		plugins_url( 'editor.css', __FILE__ ),
		array( 'wp-edit-blocks' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' )
	);
}

