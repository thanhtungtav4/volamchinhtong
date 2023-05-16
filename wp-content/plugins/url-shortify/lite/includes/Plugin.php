<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Url_Shortify
 * @subpackage Url_Shortify/includes
 */

namespace Kaizen_Coders\Url_Shortify;

use Kaizen_Coders\Url_Shortify\Admin\DB\DB;
use Kaizen_Coders\Url_Shortify\Common\Notices;

/**
 * The core plugin class.
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
 * @author     Your Name <email@example.com>
 */
class Plugin {

	/**
	 * @var Plugin $instance
	 */
	static $instance = null;
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $Url_Shortify The string used to uniquely identify this plugin.
	 */
	protected $Url_Shortify = 'url-shortify';

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version = '1.0.0';

	/**
	 * Get db classes
	 *
	 * @since 1.0.0
	 * @var object|DB
	 *
	 */
	public $db = null;

	/**
	 * Get Notice class
	 *
	 * @since 1.0.0
	 * @var object|Notices
	 *
	 */
	public $notices = null;

	/**
	 * Get access
	 *
	 * @var Access
	 *
	 * @since 1.3.10
	 */
	public $access = null;

	/**
	 * @var \WP_User
	 *
	 * @since 1.3.10
	 */
	public $current_user = null;

	/**
	 * @var Request
	 *
	 * @since 1.3.10
	 */
	public $request = null;

	/**
	 * Plugin constructor.
	 *
	 * @param string $version
	 *
	 * @since 1.0.0
	 */
	public function __construct( $version = '' ) {

		$this->version = $version;
		$this->loader  = new Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );
		$plugin_i18n->load_plugin_textdomain();

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin( $this );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );

		$this->loader->add_action( 'admin_print_scripts', $plugin_admin, 'remove_admin_notices' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'redirect_to_dashboard' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'kc_us_show_admin_notice' );

		$this->loader->add_action( 'init', $plugin_admin, 'app_output_buffer' );
		$this->loader->add_action( 'wp_dashboard_setup', $plugin_admin, 'add_dashboard_widgets' );

		$this->loader->add_filter( 'admin_footer_text', $plugin_admin, 'update_admin_footer_text' );
		$this->loader->add_filter( 'set-screen-option', $plugin_admin, 'save_screen_options', 20, 3 );

		$this->loader->add_action( 'in_plugin_update_message-url-shortify/url-shortify.php', $plugin_admin, 'in_plugin_update_message', 10, 2 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_frontend_hooks() {

		$plugin_frontend = new Frontend( $this );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->Url_Shortify;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Get Settings
	 *
	 * @return array
	 *
	 * @since 1.2.14
	 *
	 */
	public function get_settings() {

		$settings_obj = new \Kaizen_Coders\Url_Shortify\Settings( KC_US_PLUGIN_DIR . '/lite/includes/Admin/admin-settings.php', 'kc_us' );

		return $settings_obj->get_settings();
	}

	/**
	 * Define constant
	 *
	 * @since 1.0.0
	 */
	public function define_constants() {

		$upload_dir = wp_upload_dir( null, false );

		if ( ! defined( 'KC_US_LOG_DIR' ) ) {
			define( 'KC_US_LOG_DIR', $upload_dir['basedir'] . '/kaizencoders_uploads/url-shortify/logs/' );
		}

		if ( ! defined( 'KC_US_UPLOADS_DIR' ) ) {
			define( 'KC_US_UPLOADS_DIR', $upload_dir['basedir'] . '/kaizencoders_uploads/url-shortify/uploads/' );
		}

		if ( ! defined( 'KC_US_GEO_COUNTRY_DB_PATH' ) ) {
			define( 'KC_US_GEO_COUNTRY_DB_PATH', $upload_dir['basedir'] . '/GeoLite2-Country.mmdb' );
		}

		if ( ! defined( 'KC_US_AJAX_SECURITY' ) ) {
			define( 'KC_US_AJAX_SECURITY', 'url_shortify_ajax_request' );
		}

		if ( ! defined( 'KC_US_ADMIN_TEMPLATES_DIR' ) ) {
			define( 'KC_US_ADMIN_TEMPLATES_DIR', KC_US_PLUGIN_DIR . 'lite/includes/Admin/Templates' );
		}

		/*
		$constants = array(
			'KC_US_LOG_DIR'             => $upload_dir['basedir'] . '/kaizencoders-logs/us-logs/',
			'KC_US_GEO_COUNTRY_DB_PATH' => $upload_dir['basedir'] . '/GeoLite2-Country.mmdb',
			'KC_US_AJAX_SECURITY'       => 'url_shortify_ajax_request',
			'KC_US_ADMIN_TEMPLATES_DIR' => KC_US_PLUGIN_DIR . '/lite/includes/Admin/templates'
		);

		foreach ( $constants as $constant => $value ) {
			Helper::maybe_define_constant( $constant, $value );
		}
		*/

	}

	public function load_composer_packages() {

	}

	public function load_dependencies() {
		do_action( 'kc_us_load_dependencies' );
	}

	/**
	 * Is US PRO?
	 *
	 * @return bool
	 *
	 * @since 1.1.0
	 */
	public function is_pro() {

		if ( defined( 'KC_US_DEV_MODE' ) && KC_US_DEV_MODE ) {
			return true;
		}

		if ( kc_us_fs()->is_premium() && file_exists( KC_US_PLUGIN_DIR . 'pro/includes/Init_PRO.php' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Is QR code enable
	 *
	 * @return bool
	 *
	 * @since 1.3.0
	 */
	public function is_qr_enable() {
		return apply_filters( 'kc_us_is_qr_enable', false );
	}

	/**
	 * Get pricing url
	 *
	 * @since 1.1.5
	 */
	public function get_pricing_url() {
		return admin_url( 'admin.php?page=url_shortify-pricing' );
	}

	/**
	 * Get landing page url.
	 *
	 * @return string|void
	 *
	 * @since 1.5.15
	 */
	public function get_landing_page_url() {
		return admin_url( 'admin.php?page=url_shortify&landing=true' );
	}

	/**
	 * Check if this is qr request
	 *
	 * @return boolean
	 *
	 * @since 1.3.6
	 */
	public function is_qr_request() {
		return isset( $_GET['kc_us_source'] ) && 'qr' === Helper::clean( $_GET['kc_us_source'] );
	}

	/**
	 * @param $user
	 *
	 * @return bool
	 *
	 * @since 1.3.9
	 */
	public function is_administrator( $user = '' ) {

		if ( empty( $user ) ) {
			$user = wp_get_current_user();
		}

		$permission = 'manage_options';

		return $user->has_cap( $permission );
	}

	/**
	 * Is table exists?
	 *
	 * @param string $table
	 *
	 * @return bool|int
	 *
	 * @since 1.3.4
	 */
	public function is_table_exists( $table = '' ) {
		global $wpdb;

		return $wpdb->query( "SHOW TABLES LIKE '$table'" );
	}

	/**
	 * Init Classes
	 *
	 * @since 1.0.0
	 */
	public function init_classes() {

		$classes = array(
			'Kaizen_Coders\Url_Shortify\Install',
			'Kaizen_Coders\Url_Shortify\Cron',
			'Kaizen_Coders\Url_Shortify\Ajax',
			'Kaizen_Coders\Url_Shortify\Promo',
			'Kaizen_Coders\Url_Shortify\Frontend\Redirect',
			'Kaizen_Coders\Url_Shortify\Common\Actions',
			'Kaizen_Coders\Url_Shortify\PRO\Init_PRO',
			'Kaizen_Coders\Url_Shortify\Feedback',
			'Kaizen_Coders\Url_Shortify\Uninstall',
		);

		foreach ( $classes as $class ) {
			$this->loader->add_class( $class );
		}

	}

	/**
	 * Return a true instance of a class
	 *
	 * @return Plugin|object
	 *
	 * @since 1.0.0
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Plugin ) ) {

			self::$instance = new Plugin( KC_US_PLUGIN_VERSION );

			self::$instance->define_constants();
			self::$instance->load_composer_packages();
			self::$instance->load_dependencies();
			self::$instance->set_locale();
			self::$instance->init_classes();
			self::$instance->define_admin_hooks();
			self::$instance->define_frontend_hooks();

			self::$instance->db      = new DB();
			self::$instance->notices = new Notices();
			self::$instance->access  = new Access();
			self::$instance->request = new Request();
		}

		return self::$instance;
	}

}
