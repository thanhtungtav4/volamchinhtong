<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Url_Shortify
 * @subpackage Url_Shortify/includes
 */

namespace Kaizen_Coders\Url_Shortify;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Url_Shortify
 * @subpackage Url_Shortify/includes
 * @author     Your Name <email@example.com>
 */
class Deactivator {

	/**
	 * @param $network_wide
	 *
	 * @since 1.0.0
	 */
	public static function deactivate( $network_wide ) {

		if ( is_multisite() && $network_wide ) {

			global $wpdb;

			$blog_ids = $wpdb->get_col( $wpdb->prepare( "SELECT blog_id FROM $wpdb->blogs WHERE deleted = %d", 0 ) );
			foreach ( $blog_ids as $blog_id ) {
				self::deactivate_on_blog( $blog_id );
			}

		} else {
			self::do_deactivation();
		}

	}

	/**
	 * @param $blog_id
	 *
	 * @since 1.0.0
	 */
	public static function deactivate_on_blog( $blog_id ) {
		switch_to_blog( $blog_id );
		self::do_deactivation();
		restore_current_blog();
	}

	/**
	 * Handle Deactivation
	 *
	 * @return bool
	 */
	public static function do_deactivation() {
		return true;
	}

}
