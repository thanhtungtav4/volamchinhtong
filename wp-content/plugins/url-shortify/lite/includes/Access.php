<?php

/**
 * The file that defines the permission
 *
 * @link       http://example.com
 * @since      1.3.10
 *
 * @package    Url_Shortify
 * @subpackage Url_Shortify/includes
 */

namespace Kaizen_Coders\Url_Shortify;

/**
 * The Permission class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Url_Shortify
 * @subpackage Url_Shortify/includes
 * @author     Your Name <hello@kaizencoders.com>
 */
class Access {

	/**
	 * @var \WP_User|null
	 *
	 * @since 1.3.10
	 */
	public $user = null;

	/**
	 * @var array|string[]|null
	 *
	 * @since 1.3.10
	 */
	public $permissions = null;

	/**
	 * Access constructor.
	 *
	 * @param string $user
	 *
	 * @since 1.3.10
	 */
	public function __construct() {

	}

	/**
	 * Get current user ID.
	 *
	 * @return int
	 *
	 * @since 1.6.1
	 */
	public function get_current_user_id() {
		$user = \wp_get_current_user();

		return $user->ID;
	}
	/**
	 * Get all permissions
	 *
	 * @return array|string[]
	 *
	 * @since 1.3.10
	 */
	public function get_permissions( $user = '' ) {

		$permissions = array();

		if(! $user instanceof \WP_User) {
			$user = \wp_get_current_user();
		}

		if ( ! $user->exists() ) {
			return $permissions;
		}

		// Is user administrator? User has access to all submenus
		if ( US()->is_administrator( $user ) ) {
			return array(
				'create_links',
				'manage_links',
				'manage_groups',
				'manage_settings',
				'manage_custom_domains',
                'manage_utm_presets'
			);
		}

		$permissions = apply_filters( 'kc_us_user_permissions', $permissions, $user );

		return array_unique( $permissions );
	}

	/**
	 * Can user?
	 *
	 * @param string $permission
	 *
	 * @return bool
	 *
	 * @since 1.3.10
	 */
	public function can( $permission = '' ) {
		return in_array( $permission, $this->get_permissions() );
	}

}
