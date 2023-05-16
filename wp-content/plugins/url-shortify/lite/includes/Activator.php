<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Url_Shortify
 * @subpackage Url_Shortify/includes
 */

namespace Kaizen_Coders\Url_Shortify;

use Kaizen_Coders\Url_Shortify\Install;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Url_Shortify
 * @subpackage Url_Shortify/includes
 * @author     Kaizen Coders <hello@kaizencoders.com>
 */
class Activator {

	/**
	 * 
	 * @since 1.0.0
	 */
	static $redirect_option = 'url_shortify_do_activation_redirect';

	/**
	 * @param $network_wide
	 *
	 * @since 1.0.0
	 */
	public static function activate( $network_wide ) {

		global $wpdb;

		if ( is_multisite() && $network_wide ) {

			// Get all active blogs in the network and activate plugin on each one
			$blog_ids = $wpdb->get_col( $wpdb->prepare( "SELECT `blog_id` FROM $wpdb->blogs WHERE `deleted` = %d", 0 ) );
			foreach ( $blog_ids as $blog_id ) {
				self::activate_on_blog( $blog_id );
			}
		} else {
			self::do_activate();
			add_option( self::$redirect_option, true );
		}

	}

	/**
	 * Activate on specific blog
	 *
	 * @param $blog_id
	 *
	 * @since 1.0.0
	 */
	public static function activate_on_blog( $blog_id ) {
		switch_to_blog( $blog_id );
		self::do_activate();
		add_option( self::$redirect_option, true );
		restore_current_blog();
	}

	/**
	 * Run Installer
	 *
	 * @since 1.0.0
	 */
	public static function do_activate() {
		Install::install();
	}

}
