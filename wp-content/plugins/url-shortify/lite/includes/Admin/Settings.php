<?php

namespace Kaizen_Coders\Url_Shortify\Admin;

use Kaizen_Coders\Url_Shortify\Helper;

class Settings {

	/**
	 * @var string
	 */
	private $plugin_path;

	/**
	 * @var \Kaizen_Coders\Url_Shortify\Settings
	 */
	private $wpsf;

	/**
	 * WPSFTest constructor.
	 */
	public function __construct() {

		$this->plugin_path = plugin_dir_path( __FILE__ );

		$this->wpsf = new \Kaizen_Coders\Url_Shortify\Settings(  $this->plugin_path . '/admin-settings.php', 'kc_us' );

		// Add admin menu
		add_action( 'admin_menu', array( $this, 'add_settings_page' ), 20 );

		// Add an optional settings validation filter (recommended)
		add_filter( $this->wpsf->get_option_group() . '_settings_validate', array( &$this, 'validate_settings' ) );
	}

	/**
	 * Add settings page.
	 */
	public function add_settings_page() {

		$this->wpsf->add_settings_page( array(
			'parent_slug' => 'url_shortify',
			'page_title'  => __( 'Settings', 'url-shortify' ),
			'menu_title'  => __( 'Settings', 'url-shortify' ),
			'capability'  => 'edit_posts',
		) );
	}

	/**
	 * Validate settings.
	 *
	 * @param $input
	 *
	 * @return mixed
	 */
	public function validate_settings( $input ) {

		// `links_auto_create_links_for_cpt` expects an array. If empty, it sets as 0 (zero). So, setting as an empty array.
		$auto_create_links_for_cpt = Helper::get_data( $input, 'links_auto_create_links_for_cpt', array() );
		if ( 0 == $auto_create_links_for_cpt ) {
			$input['links_auto_create_links_for_cpt'] = array();
		}

		// Do your settings validation here
		// Same as $sanitize_callback from http://codex.wordpress.org/Function_Reference/register_setting
		return $input;
	}
}
