<?php

/**
 *
 * URL Shortify
 *
 * URL Shortify helps you beautify, manage, share & cloak any links on or off of your WordPress website. Create links that look how you want using your own domain name!
 *
 * @package   Url_Shortify
 * @author    Kaizen Coders <hello@kaizencoders.com>
 * @license   GPL-3.0+
 * @link      http://wordpress.org/plugins/url-shortify
 * @copyright 2020-22 KaizenCoders
 *
 * @wordpress-plugin
 *
 * Plugin Name:       URL Shortify
 * Plugin URI:        http://wordpress.org/plugins/url-shortify
 * Description:       URL Shortify helps you beautify, manage, share & cloak any links on or off of your WordPress website. Create links that look how you want using your own domain name!
 * Version:           1.6.2
 * Author:            KaizenCoders
 * Author URI:        https://kaizencoders.com/
 * Tested up to:      6.2
 * Requires PHP:      5.6
 * Text Domain:       url-shortify
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses
 * Domain Path:       /languages
 *
 * @fs_premium_only /pro/
 * @fs_ignore /vendor/, /lite/dist/styles/app.css, /lite/scripts/app.js
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( function_exists( 'kc_us_fs' ) ) {
	kc_us_fs()->set_basename( true, __FILE__ );
} else {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 */
	if ( ! defined( 'KC_US_PLUGIN_VERSION' ) ) {
		define( 'KC_US_PLUGIN_VERSION', '1.6.2' );
	}

	/**
	 * Minimum PHP version required for URL Shortify
	 *
	 * @since 1.0.0
	 *
	 */
	if ( ! defined( 'KC_US_MIN_PHP_VER' ) ) {
		define( 'KC_US_MIN_PHP_VER', '5.6' );
	}


	if ( ! function_exists( 'kc_us_fs' ) ) {
		// Create a helper function for easy SDK access.
		function kc_us_fs() {
			global $kc_us_fs;

			if ( ! isset( $kc_us_fs ) ) {
				// Include Freemius SDK.
				require_once dirname( __FILE__ ) . '/freemius/start.php';

				$kc_us_fs = fs_dynamic_init( array(
					'id'                  => '6054',
					'slug'                => 'url-shortify',
					'type'                => 'plugin',
					'public_key'          => 'pk_62af18f49c6c943300b43e8b1d027',
					'is_premium'          => false,
					'has_premium_version' => true,
					'has_addons'          => false,
					'has_paid_plans'      => true,
					'has_affiliation'     => 'selected',
					'menu'                => array(
						'slug'       => 'url_shortify',
						'first-path' => 'admin.php?page=url_shortify',
						'account'    => true,
						'contact'    => true,
						'support'    => true,
						'affiliation'  => false
					),

					'is_live' => true
				) );
			}

			return $kc_us_fs;
		}

		// Init Freemius.
		kc_us_fs();
		// Signal that SDK was initiated.
		do_action( 'kc_us_fs_loaded' );
	}

	if ( ! function_exists( 'kc_us_fail_php_version_notice' ) ) {
		/**
		 * URL Shortify admin notice for minimum PHP version.
		 *
		 * Warning when the site doesn't have the minimum required PHP version.
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 */
		function kc_us_fail_php_version_notice() {
			/* translators: %s: PHP version */
			$message      = sprintf( esc_html__( 'URL Shortify requires PHP version %s+, plugin is currently NOT RUNNING.', 'url-shortify' ), KC_US_MIN_PHP_VER );
			$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
			echo wp_kses_post( $html_message );
		}
	}

	if ( ! version_compare( PHP_VERSION, KC_US_MIN_PHP_VER, '>=' ) ) {
		add_action( 'admin_notices', 'kc_us_fail_php_version_notice' );

		return;
	}

	if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
		require_once dirname( __FILE__ ) . '/vendor/autoload.php';
	}

	// Plugin Folder Path.
	if ( ! defined( 'KC_US_PLUGIN_DIR' ) ) {
		define( 'KC_US_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	}

	// PRO Plugin Folder Path.
	if ( ! defined( 'KC_US_PRO_PLUGIN_DIR' ) ) {
		define( 'KC_US_PRO_PLUGIN_DIR', KC_US_PLUGIN_DIR . '/pro' );
	}

	if ( ! defined( 'KC_US_PLUGIN_ASSETS_DIR' ) ) {
		define( 'KC_US_PLUGIN_ASSETS_DIR', KC_US_PLUGIN_DIR . 'lite/dist/assets' );
	}

	if ( ! defined( 'KC_US_PLUGIN_BASE_NAME' ) ) {
		define( 'KC_US_PLUGIN_BASE_NAME', plugin_basename( __FILE__ ) );
	}

	if ( ! defined( 'KC_US_PLUGIN_FILE' ) ) {
		define( 'KC_US_PLUGIN_FILE', __FILE__ );
	}

	if ( ! defined( 'KC_US_PLUGIN_URL' ) ) {
		define( 'KC_US_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	}

	if ( ! defined( 'KC_US_PLUGIN_ASSETS_DIR_URL' ) ) {
		define( 'KC_US_PLUGIN_ASSETS_DIR_URL', KC_US_PLUGIN_URL . 'lite/dist/assets' );
	}

	if ( ! defined( 'KC_US_PLUGIN_STYLES_DIR_URL' ) ) {
		define( 'KC_US_PLUGIN_STYLES_DIR_URL', KC_US_PLUGIN_URL . 'lite/dist/styles' );
	}

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in lib/Activator.php
	 */
	\register_activation_hook( __FILE__, '\Kaizen_Coders\Url_Shortify\Activator::activate' );

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in lib/Deactivator.php
	 */
	\register_deactivation_hook( __FILE__, '\Kaizen_Coders\Url_Shortify\Deactivator::deactivate' );


	if ( ! function_exists( 'US' ) ) {
		/**
		 *
		 * @since 1.0.0
		 */
		function US() {
			return \Kaizen_Coders\Url_Shortify\Plugin::instance();
		}
	}

	US()->run();
}
