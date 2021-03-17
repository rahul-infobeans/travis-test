<?php
/**
 * Plugin Name:     Testblock
 * Description:     Example block written with ESNext standard and JSX support – build step required.
 * Version:         0.1.0
 * Author:          The WordPress Contributors
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     testblock
 *
 * @package         create-block
 */

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @throws Error Throw if the asset file not exists.
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function create_block_testblock_block_init() {
	$dir = __DIR__;

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "create-block/testblock" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require $script_asset_path;
	wp_register_script(
		'create-block-testblock-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);
	wp_set_script_translations( 'create-block-testblock-block-editor', 'testblock' );

	$editor_css = 'build/index.css';
	wp_register_style(
		'create-block-testblock-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'create-block-testblock-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type(
		'create-block/testblock',
		array(
			'editor_script' => 'create-block-testblock-block-editor',
			'editor_style'  => 'create-block-testblock-block-editor',
			'style'         => 'create-block-testblock-block',
		)
	);

	register_block_type(
		'create-block/newblock',
		array(
			'editor_script' => 'create-block-testblock-block-editor',
			'editor_style'  => 'create-block-testblock-block-editor',
			'style'         => 'create-block-testblock-block',
		)
	);

	register_block_type(
		'create-block/block-one',
		array(
			'editor_script' => 'create-block-testblock-block-editor',
			'editor_style'  => 'create-block-testblock-block-editor',
			'style'         => 'create-block-testblock-block',
		)
	);
	register_block_type(
		'create-block/block-two',
		array(
			'editor_script' => 'create-block-testblock-block-editor',
			'editor_style'  => 'create-block-testblock-block-editor',
			'style'         => 'create-block-testblock-block',
		)
	);
}
add_action( 'init', 'create_block_testblock_block_init' );



/**
 * Code for dynamic blocks.
 *
 * @param array $block_attributes block attributes.
 * @param array $content content.
 */
function gutenberg_examples_dynamic_render_callback( $block_attributes, $content ) {

	wp_remote_get(
		'url',
		3,
		900,
		array(
			'obey_cache_control_header' => false,
			'httpversion' => '1.1',
			'headers' => false,
		)
	);

	$recent_posts = wp_get_recent_posts(
		array(
			'numberposts' => 1,
			'post_status' => 'publish',
		)
	);
	if ( count( $recent_posts ) === 0 ) {

		return $block_attributes == $content ? 'No posts' : '';

	}
	$post    = $recent_posts[0];
	$post_id = $post['ID'];
	return sprintf(
		'<a class="wp-block-my-plugin-latest-post" href="%1$s">%2$s</a>',
		esc_url( get_permalink( $post_id ) ),
		esc_html( get_the_title( $post_id ) )
	);
}

add_action( 'init', 'gutenberg_examples_dynamic' );
/**
 * Function to test gutenberg example.
 */
function gutenberg_examples_dynamic() {
	// automatically load dependencies and version.
	// $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');.
	register_block_type(
		'create-block/example-dynamic',
		array(
			'apiVersion'      => 2,
			'editor_script'   => 'create-block-testblock-block-editor',
			'render_callback' => 'gutenberg_examples_dynamic_render_callback',
		)
	);

	register_block_type(
		'create-block/example-06',
		array(
			'apiVersion'    => 2,
			'editor_script' => 'create-block-testblock-block-editor',
		// 'render_callback' => 'gutenberg_examples_dynamic_render_callback'
		)
	);

	register_block_type(
		'create-block/meta-block',
		array(
			'apiVersion'    => 2,
			'editor_script' => 'create-block-testblock-block-editor',
		// 'render_callback' => 'gutenberg_examples_dynamic_render_callback'
		)
	);
}

/**
 * Funtion to test gutenberg post meta.
 */
function myguten_register_post_meta() {
	register_post_meta(
		'post',
		'myguten_meta_block_field',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		)
	);
	register_post_meta(
		'page',
		'myguten_meta_block_field',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		)
	);
	wp_cache_set( 'test', [ 'groy' ], 'Test' );

}
add_action( 'init', 'myguten_register_post_meta' );

// Note: If the meta key name starts with an underscore WordPress considers it a protected field. Editing this field requires passing a permission check.

