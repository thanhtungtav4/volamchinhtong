<?php

namespace Kaizen_Coders\Url_Shortify\Admin\Controllers;

use Kaizen_Coders\Url_Shortify\Cache;
use Kaizen_Coders\Url_Shortify\Common\Utils;
use Kaizen_Coders\Url_Shortify\Helper;

class DashboardController extends StatsController {
	/**
	 * DashboardController constructor.
	 *
	 * @since 1.1.5
	 */
	public function __construct() {

		parent::__construct();
	}

	/**
	 * Render dashboard
	 *
	 * @since 1.1.5
	 */
	public function render() {

		$refresh = (int) Helper::get_request_data( 'refresh', 0 );

		// If we have the data in cache, get it from it.
		// We store data in cache for 3 hours
		$data = Cache::get_transient( 'dashboard_stats' );

		if ( empty( $data ) || ( 1 === $refresh ) ) {
			$total_links = US()->db->links->count();

			$show_kpis = false;
			if ( $total_links > 0 ) {

				$total_groups  = US()->db->groups->count();
				$total_clicks  = US()->db->clicks->count();
				$unique_clicks = US()->db->clicks->get_total_unique_clicks();

				$links_url  = admin_url( 'admin.php?page=us_links' );
				$groups_url = admin_url( 'admin.php?page=us_groups' );

				$data = array(
					'kpis' => array(
						'total_links' => array(
							'title' => __( 'Total Links', 'url-shortify' ),
							'count' => number_format_i18n($total_links),
							'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>',
							'url'   => $links_url
						),

						'total_groups' => array(
							'title' => __( 'Total Groups', 'url-shortify' ),
							'count' => number_format_i18n($total_groups),
							'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>',
							'url'   => $groups_url
						),

						'total_clicks' => array(
							'title' => __( 'Total Clicks', 'url-shortify' ),
							'count' => number_format_i18n($total_clicks),
							'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>',
							'url'   => ''
						),

						'unique_clicks' => array(
							'title' => __( 'Unique Clicks', 'url-shortify' ),
							'count' => number_format_i18n($unique_clicks),
							'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>',
							'url'   => ''
						),
					)
				);

				$stats_controller = new StatsController();

				$reports_data = $stats_controller->prepare_data();

				$data['reports']              = $reports_data['reports'];
				$data['click_data_for_graph'] = $reports_data['click_data_for_graph'];

				$link_ids = US()->db->links->get_column( 'id' );

				$data['browser_info'] = $this->get_browser_info_for_graph( $link_ids );
				$data['device_info']  = $this->get_device_info_for_graph( $link_ids );
				$data['os_info']      = $this->get_os_info_for_graph( $link_ids );

				$countries_data = $this->get_country_info_for_graph( $link_ids );

				$country_info = array();

				if ( Helper::is_forechable( $countries_data ) ) {

					$tota_count = array_sum( array_values( $countries_data ) );

					foreach ( $countries_data as $country_iso_code => $total ) {

						if ( 'Others' === $country_iso_code ) {
							$country = __( 'Others', 'url-shortify' );
						} else {
							$country = Utils::get_country_name_from_iso_code( $country_iso_code );
						}

						$country_info[ $country_iso_code ]['name']       = $country;
						$country_info[ $country_iso_code ]['total']      = number_format_i18n( $total );
						$country_info[ $country_iso_code ]['percentage'] = round( ( $total * 100 ) / $tota_count, 2 );
						$country_info[ $country_iso_code ]['flag_url']   = Utils::get_country_icon_url( $country_iso_code );
					}
				}

				$data['country_info'] = $country_info;

				$data['referrers_info'] = $this->get_referrers_info_for_graph( $link_ids );

				$show_kpis = true;
			}

			$data['show_kpis']     = $show_kpis;
			$data['new_link_url']  = admin_url( 'admin.php?page=us_links&action=new' );
			$data['new_group_url'] = admin_url( 'admin.php?page=us_groups&action=new' );

			$data['last_updated_on'] = time();

			// Store data in cache for 3 hours
			Cache::set_transient( 'dashboard_stats', $data, HOUR_IN_SECONDS * 3 );
		}

		include_once KC_US_ADMIN_TEMPLATES_DIR . '/dashboard.php';
	}

}
