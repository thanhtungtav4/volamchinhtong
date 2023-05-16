<?php

namespace Kaizen_Coders\Url_Shortify\Admin\Controllers;

use Kaizen_Coders\Url_Shortify\Cache;
use Kaizen_Coders\Url_Shortify\Common\Utils;
use Kaizen_Coders\Url_Shortify\Helper;

class GroupStatsController extends StatsController {
	/**
	 * Group ID
	 *
	 * @var null
	 *
	 * @since 1.1.3
	 */
	public $group_id = null;

	/**
	 * Link_Stats constructor.
	 *
	 * @param null $group_id
	 *
	 * @since 1.0.4
	 */
	public function __construct( $group_id = null ) {

		$this->group_id = $group_id;

		parent::__construct();
	}

	/**
	 * Render Group stats page
	 *
	 * @since 1.1.7
	 */
	public function render() {

		$data = $this->prepare_data();

		include KC_US_ADMIN_TEMPLATES_DIR . '/group-stats.php';
	}

	/**
	 * Prepare data for report
	 *
	 * @return array|object|void|null
	 *
	 * @since 1.1.7
	 */
	public function prepare_data() {

		$refresh = (int) Helper::get_request_data( 'refresh', 0 );

		// If we have the data in cache, get it from it.
		// We store data in cache for 3 hours
		$data = Cache::get_transient( 'group_stats_' . $this->group_id );

		if ( ! empty( $data ) && ( 1 !== $refresh ) ) {
			return $data;
		}

		$data = US()->db->groups->get_by_id( $this->group_id );

		$link_ids = US()->db->links_groups->get_link_ids_by_group_id( $this->group_id );

		if ( empty( $link_ids ) ) {
			return $data;
		}

		$data['links'] = US()->db->links->get_by_ids( $link_ids );

		// Click History for last 7 days
		$days = apply_filters( 'kc_us_clicks_info_for_days', 7 );

		$data['reports']['clicks'] = $this->get_clicks_info( $days, $link_ids );

		$days = apply_filters( 'kc_us_clicks_count_for_days', 7 );

		$data['click_data_for_graph'] = $this->get_clicks_count_by_days( $days, $link_ids );

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
				$country_info[ $country_iso_code ]['total']      = $total;
				$country_info[ $country_iso_code ]['percentage'] = round( ( $total * 100 ) / $tota_count, 2 );
				$country_info[ $country_iso_code ]['flag_url']   = Utils::get_country_icon_url( $country_iso_code );
			}
		}

		$data['country_info'] = $country_info;

		$data['referrers_info'] = $this->get_referrers_info_for_graph( $link_ids );

		$data['last_updated_on'] = time();

		// Store data in cache for 3 hours
		Cache::set_transient( 'group_stats_' . $this->group_id, $data, HOUR_IN_SECONDS * 3 );

		return $data;
	}


}
