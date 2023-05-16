<?php

namespace Kaizen_Coders\Url_Shortify\Admin\Controllers;

use Kaizen_Coders\Url_Shortify\Common\Import;
use Kaizen_Coders\Url_Shortify\Helper;

class ToolsController extends BaseController {
	/**
	 * ToolsController constructor.
	 *
	 * @since 1.1.9
	 */
	public function __construct() {

		parent::__construct();
	}

	/**
	 * Render Tools
	 *
	 * @since 1.1.9
	 */
	public function render() {

		$template_data['links'] = $this->get_links();

		include_once KC_US_ADMIN_TEMPLATES_DIR . '/tools.php';
	}

	/**
	 * Get links
	 *
	 * @since 1.3.4
	 */
	public function get_links() {

		$links['import'] = array(
			'title' => __( 'Import', 'url-shortify' ),
			'link'  => add_query_arg( array( 'tab' => 'import' ), admin_url( 'admin.php?page=us_tools' ) )
		);

		/*
		$links['export'] = array(
			'title' => __( 'Export', 'url-shortify' ),
			'link'  => add_query_arg( array( 'tab' => 'export' ), admin_url( 'admin.php?page=us_tools' ) )
		);
		*/

		return apply_filters('kc_us_filter_tools_links', $links);;
	}

}
