<?php


namespace Kaizen_Coders\Url_Shortify;


class Uninstall {

	/**
	 * Init Uninstall
	 *
	 * @since 1.4.9
	 */
	public function init() {
		kc_us_fs()->add_action( 'after_uninstall', array( $this, 'uninstall_cleanup' ) );
	}

	/**
	 * Delete plugin data
	 *
	 * @since 1.4.9
	 */
	public function uninstall_cleanup() {

		$settings = US()->get_settings();

		$delete_on_uninstall = Helper::get_data( $settings, 'general_settings_delete_plugin_data', 0 );

		if ( 1 == $delete_on_uninstall ) {
			// Delete Tables
			$this->delete_tables();

			// Delete Options
			$this->delete_options();
		}

	}

	/**
	 * Delete Tables
	 *
	 * @since 1.4.9
	 */
	public function delete_tables() {
		global $wpdb;

		$tables = array(
			$wpdb->prefix . 'kc_us_links',
			$wpdb->prefix . 'kc_us_clicks',
			$wpdb->prefix . 'kc_us_groups',
			$wpdb->prefix . 'kc_us_links_groups',
			$wpdb->prefix . 'kc_us_domains',
		);

		foreach ( $tables as $table ) {
			$wpdb->query( "DROP TABLE IF EXISTS {$table}" );
		}
	}

	/**
	 * Delete Options
	 *
	 * @since 1.4.9
	 */
	public function delete_options() {
		global $wpdb;

		$settings = array(
			'settings'
		);

		foreach ( $settings as $setting ) {
			Option::delete( $setting );
		}

		$option_name = '%' . $wpdb->esc_like( 'kc_us_' ) . '%';

		$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE %s", $option_name ) );
	}

}