<?php

namespace Altis\CMS;

use const Altis\ROOT_DIR;
use function Altis\get_config;

/**
 * Main bootstrap / entry point for the CMS module.
 */
function bootstrap() {
	$config = get_config()['modules']['cms'];
	Remove_Updates\bootstrap();

	if ( $config['branding'] ) {
		Branding\bootstrap();
	}

	if ( $config['login-logo'] ) {
		add_action( 'login_header', __NAMESPACE__ . '\\add_login_logo' );
	}

	if ( $config['shared-blocks'] ) {
		Block_Editor\bootstrap();
	}

	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugins', 1 );

	if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
		define( 'DISALLOW_FILE_EDIT', true );
	}

	add_filter( 'pre_site_option_fileupload_maxk', __NAMESPACE__ . '\\override_fileupload_maxk_option' );
}

/**
 * Add the custom login logo to the login page.
 */
function add_login_logo() {
	$logo = get_config()['modules']['cms']['login-logo'];
	?>
	<style>
		.login h1 a {
			background-image: url('<?php echo site_url( $logo ) ?>');
			background-size: contain;
			width: auto;
		}
	</style>
	<?php
}

/**
 * Load plugins that are bundled with the CMS module.
 */
function load_plugins() {
	require_once ROOT_DIR . '/vendor/stuttter/wp-user-signups/wp-user-signups.php';
}

/**
 * Increase the max upload size (in kb) to 1GB.
 *
 * @return integer
 */
function override_fileupload_maxk_option() : int {
	return 1024 * 1024;
}
