<?php

namespace Kaizen_Coders\Url_Shortify\Admin\DB;

use Kaizen_Coders\Url_Shortify\Helper;

class Clicks extends Base_DB {
	/**
	 * Table Name
	 *
	 * @since 1.0.0
	 * @var string
	 *
	 */
	public $table_name;
	/**
	 * Table Version
	 *
	 * @since 1.0.0
	 * @var string
	 *
	 */
	public $version;
	/**
	 * Primary key
	 *
	 * @since 1.0.0
	 * @var string
	 *
	 */
	public $primary_key;

	/**
	 * Initialize
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		global $wpdb;

		parent::__construct();

		$this->table_name = $wpdb->prefix . 'kc_us_clicks';

		$this->version = '1.0';

		$this->primary_key = 'id';
	}

	/**
	 * Get columns and formats
	 *
	 * @since 1.0.0
	 */
	public function get_columns() {

		return array(
			'id'              => '%d',
			'link_id'         => '%d',
			'uri'             => '%s',
			'host'            => '%s',
			'referer'         => '%s',
			'is_first_click'  => '%d',
			'is_robot'        => '%d',
			'user_agent'      => '%s',
			'os'              => '%s',
			'device'          => '%s',
			'browser_type'    => '%s',
			'browser_version' => '%s',
			'visitor_id'      => '%s',
			'country'         => '%s',
			'ip'              => '%s',
			'created_at'      => '%s'
		);
	}

	/**
	 * Get default column values
	 *
	 * @since 1.0.0
	 */
	public function get_column_defaults() {

		return array(
			'link_id'         => null,
			'uri'             => null,
			'host'            => null,
			'referer'         => null,
			'is_first_click'  => 0,
			'is_robot'        => 0,
			'user_agent'      => null,
			'os'              => null,
			'device'          => null,
			'browser_type'    => null,
			'browser_version' => null,
			'visitor_id'      => null,
			'country'         => null,
			'ip'              => null,
			'created_at'      => Helper::get_current_date_time(),
		);
	}

	/**
	 * Get total by link ids
	 *
	 * @param array|null $link_ids
	 *
	 * @return int|string|null
	 *
	 * @since 1.2.4
	 */
	public function get_total_by_link_ids( $link_ids = null ) {

		if ( empty( $link_ids ) ) {
			return 0;
		}

		if ( ! is_array( $link_ids ) ) {
			$link_ids = array( $link_ids );
		}

		$link_ids_str = $this->prepare_for_in_query( $link_ids );

		$where = "link_id IN ($link_ids_str)";

		return $this->count( $where );
	}

	/**
	 * Get total unique clicks by link ids
	 *
	 * @param array|null $link_ids
	 *
	 * @return int|string|null
	 *
	 * @since 1.2.4
	 */
	public function get_total_unique_by_link_ids( $link_ids = null ) {
		global $wpdb;

		if ( empty( $link_ids ) ) {
			return 0;
		}

		if ( ! is_array( $link_ids ) ) {
			$link_ids = array( $link_ids );
		}

		$link_ids_str = $this->prepare_for_in_query( $link_ids );

		$where = $wpdb->prepare( "link_id IN ($link_ids_str) AND is_first_click = %d", 1 );

		return $this->count( $where );

	}

	/**
	 * Delete clicks by link id
	 *
	 * @param null $link_id
	 *
	 * @return bool
	 *
	 * @since 1.0.2
	 */
	public function delete_by_link_id( $link_id = null ) {

		if ( empty( $link_id ) ) {
			return false;
		}

		return $this->delete_by( 'link_id', $link_id );
	}

	/**
	 * Get clicks data
	 *
	 * @param int $link_id
	 * @param int $days
	 *
	 * @return array
	 *
	 * @since 1.0.4
	 */
	public function get_data_by_link_id( $link_id = 0, $days = 7 ) {
		global $wpdb;

		$where = $wpdb->prepare( 'link_id = %d AND created_at >= DATE_SUB(NOW(), INTERVAL %d DAY) ORDER BY created_at DESC', $link_id, $days );

		return $this->get_by_conditions( $where );
	}

	/**
	 * Get total unique clicks
	 *
	 * @return string|null
	 *
	 * @since 1.1.5
	 */
	public function get_total_unique_clicks() {
		global $wpdb;

		$where = $wpdb->prepare( 'is_first_click = %d', 1 );

		return $this->count( $where );
	}

	/**
	 * Get click history
	 *
	 * @param int $days
	 *
	 * @param array $link_ids
	 *
	 * @return array
	 *
	 * @since 1.1.7
	 */
	public function get_clicks_info( $days = 7, $link_ids = array() ) {
		global $wpdb;

		$clicks_table = "{$wpdb->prefix}kc_us_clicks";
		$links_table  = "{$wpdb->prefix}kc_us_links";

		$query = "SELECT clicks.*, links.name as name FROM {$clicks_table} as clicks, {$links_table} as links";

		$where[] = 'clicks.link_id = links.id AND clicks.created_at >= DATE_SUB(NOW(), INTERVAL %d DAY)';

		if ( ! empty( $link_ids ) ) {
			$link_ids_str = $this->prepare_for_in_query( $link_ids );

			$where[] = "link_id IN ($link_ids_str)";
		}

		$where_str = implode( ' AND ', $where );

		$query .= " WHERE $where_str ORDER BY clicks.created_at DESC LIMIT 0, 100";

		$query = $wpdb->prepare( $query, $days );

		return $wpdb->get_results( $query, ARRAY_A );
	}

	/**
	 * Get clicks data
	 *
	 * @param string $start_date
	 * @param string $end_date
	 * @param array $link_ids
	 *
	 * @return array
	 *
	 * @since 1.1.6
	 */
	public function get_clicks_count_by_days( $start_date = '', $end_date = '', $link_ids = array() ) {
		global $wpdb;

		$clicks_table = "{$wpdb->prefix}kc_us_clicks";

		$query = "SELECT DATE(created_at) as date, IF(count(*) IS NULL, 0, count(*)) as count FROM $clicks_table";

		$where = array();
		if ( ! empty( $link_ids ) ) {

			$link_ids_str = $this->prepare_for_in_query( $link_ids );

			$where[] = "link_id IN ($link_ids_str)";
		}

		$where[] = $wpdb->prepare( 'DATE(created_at) >= %s AND DATE(created_at) <= %s ', $start_date, $end_date );

		if ( ! empty( $where ) ) {
			$where = implode( ' AND ', $where );
			$query .= " WHERE $where";
		}

		$query .= 'GROUP BY DATE(created_at) ORDER BY DATE(created_at) DESC';

		$results = $wpdb->get_results( $query, ARRAY_A );

		$data = array();
		if ( Helper::is_forechable( $results ) ) {
			foreach ( $results as $result ) {
				$data[ $result['date'] ] = $result['count'];
			}

			// Move pointer to last
			end( $data );

			$last_date = key( $data );

			$stop_date = date( 'Y-m-d', strtotime( $last_date . ' -1 day' ) );

		} else {
			$stop_date = date( 'Y-m-d', strtotime( 'today -1 day' ) );
		}


		$final_data = array();
		for ( $i = 0; $stop_date <= $end_date; $i ++ ) {
			$final_data[ $stop_date ] = Helper::get_data( $data, $stop_date, 0 );

			$stop_date = date( 'Y-m-d', strtotime( $stop_date . ' +1 day' ) );
		}

		return $final_data;
	}

	/**
	 * Get browser info
	 *
	 * @param array $link_ids
	 *
	 * @return array
	 *
	 * @since 1.2.1
	 */
	public function get_browser_info( $link_ids = array() ) {

		if ( empty( $link_ids ) ) {
			return array();
		}

		$link_ids_str = $this->prepare_for_in_query( $link_ids );

		$columns = array( 'browser_type', 'count(*) as total' );
		$where   = "link_id IN ( $link_ids_str ) GROUP BY browser_type";

		$results = $this->get_columns_by_condition( $columns, $where );

		return $this->convert_to_associative_array( $results, 'browser_type', 'total' );
	}

	/**
	 * Get Country info
	 *
	 * @param array $link_ids
	 *
	 * @return array
	 *
	 * @since 1.2.1
	 */
	public function get_country_info( $link_ids = array() ) {

		if ( empty( $link_ids ) ) {
			return array();
		}

		$link_ids_str = $this->prepare_for_in_query( $link_ids );

		$columns = array( 'country', 'count(*) as total' );
		$where   = "link_id IN ( $link_ids_str ) GROUP BY country";

		$results = $this->get_columns_by_condition( $columns, $where );

		return $this->convert_to_associative_array( $results, 'country', 'total' );
	}

	/**
	 * Get Referrers info
	 *
	 * @param array $link_ids
	 *
	 * @return array
	 *
	 * @since 1.2.1
	 */
	public function get_referrers_info( $link_ids = array() ) {

		if ( empty( $link_ids ) ) {
			return array();
		}

		$link_ids_str = $this->prepare_for_in_query( $link_ids );

		$columns = array( 'referer', 'count(*) as total' );
		$where   = "link_id IN ( $link_ids_str ) GROUP BY referer";

		$results = $this->get_columns_by_condition( $columns, $where );

		$null_label = __( 'Direct, Email, SMS', 'url-shortify' );

		return $this->convert_to_associative_array( $results, 'referer', 'total', $null_label );
	}

	/**
	 * Get Device info
	 *
	 * @param array $link_ids
	 *
	 * @return array
	 *
	 * @since 1.2.1
	 */
	public function get_device_info( $link_ids = array() ) {

		if ( empty( $link_ids ) ) {
			return array();
		}

		$link_ids_str = $this->prepare_for_in_query( $link_ids );

		$columns = array( 'device', 'count(*) as total' );
		$where   = "link_id IN ( $link_ids_str ) GROUP BY device";

		$results = $this->get_columns_by_condition( $columns, $where );

		return $this->convert_to_associative_array( $results, 'device', 'total' );
	}

	/**
	 * Get Device info
	 *
	 * @param array $link_ids
	 *
	 * @return array
	 *
	 * @since 1.2.1
	 */
	public function get_os_info( $link_ids = array() ) {

		if ( empty( $link_ids ) ) {
			return array();
		}

		$link_ids_str = $this->prepare_for_in_query( $link_ids );

		$columns = array( 'os', 'count(*) as total' );
		$where   = "link_id IN ( $link_ids_str ) GROUP BY os";

		$results = $this->get_columns_by_condition( $columns, $where );

		return $this->convert_to_associative_array( $results, 'os', 'total' );
	}

	/**
	 * Get links clicks count
	 *
	 * @param int $count
	 *
	 * @return array
	 *
	 * @since 1.4.0
	 */
	public function get_links_clicks_count( $count = 5 ) {

		$query = "SELECT link_id, count(id) as total_clicks FROM {$this->table_name} GROUP BY link_id ORDER BY total_clicks DESC limit 0, $count";

		$results = $this->get_by_query( $query );

		return $this->convert_to_associative_array($results, 'link_id', 'total_clicks');
	}

}
