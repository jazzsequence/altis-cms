<?php
/**
 * Altis CMS Module.
 *
 * @package altis/cms
 */

namespace Altis\CMS; // phpcs:ignore

function get_config() {
	return [
		'enabled' => true,
		'branding' => true,
		'large-network' => false,
		'login-logo' => '/vendor/altis/cms/assets/logo.svg',
		'shared-blocks' => true,
		'default-theme' => 'twentytwentyone',
		'remove-emoji' => true,
		'xmlrpc' => false,
		'feeds' => true,
		'cloner' => false,
		'network-ui' => [
			'disable-spam' => true,
		],
	];
}
