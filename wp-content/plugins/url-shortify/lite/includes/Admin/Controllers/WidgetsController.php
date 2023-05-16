<?php

namespace Kaizen_Coders\Url_Shortify\Admin\Controllers;

use Kaizen_Coders\Url_Shortify\Common\Utils;
use Kaizen_Coders\Url_Shortify\Helper;

class WidgetsController extends BaseController {
	/**
	 * WidgetsController constructor.
	 *
	 * @since 1.2.5
	 */
	public function __construct() {

		parent::__construct();
	}

	/**
	 * Render Shortlink Widget
	 *
	 * @since 1.2.5
	 */
	public function render_dashboard_generate_shortlink_widget() {

		$blog_url = Helper::get_blog_url();
		$slug     = Utils::get_valid_slug();
		$loading_icon_url = KC_US_PLUGIN_ASSETS_DIR_URL . '/images/loader.gif';
		$domains = Helper::get_domains();

		$action = wp_create_nonce(KC_US_AJAX_SECURITY );

		require_once KC_US_ADMIN_TEMPLATES_DIR . '/widgets/dashboard-widget.php';
	}
}
