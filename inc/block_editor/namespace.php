<?php
/**
 * Altis CMS Block Editor Additions.
 *
 * @package altis/cms
 */

namespace Altis\CMS\Block_Editor;

use Altis;

/**
 * Set up block editor modifications.
 */
function bootstrap() {
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\set_default_editor_preferences' );
	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugins' );

	add_filter( 'asset_loader_plugin_or_theme_file_uri', __NAMESPACE__ . '\\filter_asset_uri' );
}

/**
 * Load the Altis Reusable Blocks and Asset Loader plugins.
 *
 * @return void
 */
function load_plugins() {
	require_once Altis\ROOT_DIR . '/vendor/humanmade/altis-reusable-blocks/plugin.php';
	require_once Altis\ROOT_DIR . '/vendor/humanmade/asset-loader/asset-loader.php';
}

/**
 * Filter the asset URI to replace Altis\ROOT_DIR with the relative URL path.
 *
 * @param string $uri
 * @return string
 */
function filter_asset_uri( string $uri, string $path ) : string {
	if ( strpos( $path, Altis\ROOT_DIR ) === false ) {
		return $uri;
	}

	return content_url( str_replace( Altis\ROOT_DIR, '', $path ) );
}

/**
 * Queue scripts for setting default block editor preferences in WP 5.4.
 *
 * Disables default fullscreen mode and welcome guide.
 */
function set_default_editor_preferences() {
	global $wp_scripts;

	wp_register_script(
		'altis-default-editor-settings',
		plugin_dir_url( dirname( __FILE__, 2 ) ) . 'assets/editor-settings.js',
		[],
		'2020-06-04-1',
		false
	);
	wp_localize_script(
		'altis-default-editor-settings',
		'altisDefaultEditorSettings',
		[
			'uid' => get_current_user_id(),
		]
	);

	// Add default settings as a dependency of wp-data.
	$wp_scripts->registered['wp-data']->deps[] = 'altis-default-editor-settings';
}
