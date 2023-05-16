<?php

namespace Kaizen_Coders\Url_Shortify;

use Kaizen_Coders\Url_Shortify\Admin\Controllers\ImportController;
use Kaizen_Coders\Url_Shortify\Admin\Controllers\LinksController;
use Kaizen_Coders\Url_Shortify\Admin\DB\Links;

/**
 * Class Ajax
 *
 * Handle Ajax request
 *
 * @package Kaizen_Coders\Url_Shortify
 *
 * @since 1.1.3
 */
class Ajax {

	/**
	 * Init
	 *
	 * @since 1.1.3
	 */
	public function init() {
		add_action( 'wp_ajax_us_handle_request', array( $this, 'handle_request' ) );
		add_action( 'wp_ajax_nopriv_us_handle_request', array( $this, 'handle_request' ) );
	}

	/**
	 * Get accessible commands.
	 *
	 * @return mixed|void
	 *
	 * @since 1.5.12
	 */
	public function get_accessible_commands() {
		$accessible_commands = array(
			'create_short_link'
		);

		return apply_filters( 'kc_us_accessible_commands', $accessible_commands );
	}

	/**
	 * Handle Ajax Request
	 *
	 * @since 1.1.3
	 */
	public function handle_request() {

		$params = Helper::get_request_data('', '', false);

		if ( empty( $params ) || empty( $params['cmd'] ) ) {
			return;
		}

		check_ajax_referer( KC_US_AJAX_SECURITY, 'security' );

		$cmd = Helper::get_data( $params, 'cmd', '' );

		$ajax = US()->is_pro() ? new \Kaizen_Coders\Url_Shortify\PRO\Ajax() : $this;

		if ( in_array( $cmd, $this->get_accessible_commands() ) && is_callable( array( $ajax, $cmd ) ) ) {
			$ajax->$cmd( $params );
		}
	}

	/**
	 * Create Short Link
	 *
	 * @param array $data
	 *
	 * @since 1.1.3
	 */
	public function create_short_link( $data = array() ) {

		$link_controller = new LinksController();

		$response = $link_controller->create( $data );

		wp_send_json( $response );
	}
}
