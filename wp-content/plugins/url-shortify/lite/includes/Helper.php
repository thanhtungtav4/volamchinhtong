<?php

namespace Kaizen_Coders\Url_Shortify;

use Kaizen_Coders\Url_Shortify\Admin\Stats;
use Kaizen_Coders\Url_Shortify\Common\Utils;

/**
 * Plugin_Name
 *
 * @package   Url_Shortify
 * @author    Kaizen Coders <hello@kaizencoders.com>
 * @link      https://kaizencoders.com
 */

/**
 * Helper Class
 */
class Helper {

	/**
	 * Whether given user is an administrator.
	 *
	 * @param \WP_User $user The given user.
	 *
	 * @return bool
	 */
	public static function is_user_admin( \WP_User $user = null ) {
		if ( is_null( $user ) ) {
			$user = wp_get_current_user();
		}

		if ( ! $user instanceof WP_User ) {
			_doing_it_wrong( __METHOD__, 'To check if the user is admin is required a WP_User object.', '1.0.0' );
		}

		return is_multisite() ? user_can( $user, 'manage_network' ) : user_can( $user, 'manage_options' );
	}

	/**
	 * What type of request is this?
	 *
	 * @param string $type admin, ajax, cron, cli or frontend.
	 *
	 * @return bool
	 * @since 1.0.0
	 *
	 */
	public function request( $type ) {
		switch ( $type ) {
			case 'admin_backend':
				return $this->is_admin_backend();
			case 'ajax':
				return $this->is_ajax();
			case 'installing_wp':
				return $this->is_installing_wp();
			case 'rest':
				return $this->is_rest();
			case 'cron':
				return $this->is_cron();
			case 'frontend':
				return $this->is_frontend();
			case 'cli':
				return $this->is_cli();
			default:
				_doing_it_wrong( __METHOD__, esc_html( sprintf( 'Unknown request type: %s', $type ) ), '1.0.0' );

				return false;
		}
	}

	/**
	 * Is installing WP
	 *
	 * @return boolean
	 */
	public function is_installing_wp() {
		return defined( 'WP_INSTALLING' );
	}

	/**
	 * Is admin
	 *
	 * @return boolean
	 * @since 1.0.0
	 *
	 */
	public function is_admin_backend() {
		return is_user_logged_in() && is_admin();
	}

	/**
	 * Is ajax
	 *
	 * @return boolean
	 * @since 1.0.0
	 *
	 */
	public function is_ajax() {
		return ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) || defined( 'DOING_AJAX' );
	}

	/**
	 * Is rest
	 *
	 * @return boolean
	 * @since 1.0.0
	 *
	 */
	public function is_rest() {
		return defined( 'REST_REQUEST' );
	}

	/**
	 * Is cron
	 *
	 * @return boolean
	 * @since 1.0.0
	 *
	 */
	public function is_cron() {
		return ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) || defined( 'DOING_CRON' );
	}

	/**
	 * Is frontend
	 *
	 * @return boolean
	 * @since 1.0.0
	 *
	 */
	public function is_frontend() {
		return ( ! $this->is_admin_backend() || ! $this->is_ajax() ) && ! $this->is_cron() && ! $this->is_rest();
	}

	/**
	 * Is cli
	 *
	 * @return boolean
	 * @since 1.0.0
	 *
	 */
	public function is_cli() {
		return defined( 'WP_CLI' ) && WP_CLI;
	}

	/**
	 * Define constant
	 *
	 * @param $name
	 * @param $value
	 *
	 * @since 1.0.0
	 */
	public static function maybe_define_constant( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Get current date time
	 *
	 * @return false|string
	 */
	public static function get_current_date_time() {
		return gmdate( 'Y-m-d H:i:s' );
	}


	/**
	 * Get current date time
	 *
	 * @return false|string
	 *
	 */
	public static function get_current_gmt_timestamp() {
		return strtotime( gmdate( 'Y-m-d H:i:s' ) );
	}

	/**
	 * Get current date
	 *
	 * @return false|string
	 *
	 */
	public static function get_current_date() {
		return gmdate( 'Y-m-d' );
	}

	/**
	 * Format date time
	 *
	 * @param $date
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public static function format_date_time( $date ) {
		$convert_date_format = get_option( 'date_format' );
		$convert_time_format = get_option( 'time_format' );

		return ( $date !== '0000-00-00 00:00:00' ) ? date_i18n( "$convert_date_format $convert_time_format", strtotime( get_date_from_gmt( $date ) ) ) : '<i class="dashicons dashicons-es dashicons-minus"></i>';
	}

	/**
	 * Clean String or array using sanitize_text_field
	 *
	 * @param $var data to sanitize
	 *
	 * @return array|string
	 *
	 * @sinc 1.0.0
	 *
	 */
	public static function clean( $var ) {
		if ( is_array( $var ) ) {
			return array_map( 'self::clean', $var );
		} else {
			return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		}
	}

	/**
	 * Get IP
	 *
	 * @return mixed|string|void
	 *
	 */
	public static function get_ip() {

		$settings = maybe_unserialize( get_option( 'kc_us_settings' ) );

		$how_to = Helper::get_data( $settings, 'reports_reporting_options_how_to_get_ip', '' );

		if ( $how_to ) {
			return ! empty( $_SERVER[ $how_to ] ) ? $_SERVER[ $how_to ] : $_SERVER['REMOTE_ADDR'];
		} else {

			$fields = array(
				'HTTP_CF_CONNECTING_IP',
				'HTTP_CLIENT_IP',
				'HTTP_X_FORWARDED_FOR',
				'HTTP_X_FORWARDED',
				'HTTP_FORWARDED_FOR',
				'HTTP_FORWARDED',
				'REMOTE_ADDR',
			);

			foreach ( $fields as $ip_field ) {
				if ( ! empty( $_SERVER[ $ip_field ] ) ) {
					return $_SERVER[ $ip_field ];
				}
			}
		}


		return $_SERVER['REMOTE_ADDR'];
	}

	/**
	 * Determines if an IP address is valid.
	 *
	 * Handles both IPv4 and IPv6 addresses.
	 *
	 * @param $ip
	 *
	 * @return false|mixed
	 *
	 * @since 1.5.0
	 */
	public static function is_ip_address( $ip ) {
		$ipv4_pattern = '/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/';

		if ( ! preg_match( $ipv4_pattern, $ip ) && ! \Requests_IPv6::check_ipv6( $ip ) ) {
			return false;
		}

		return $ip;
	}

	/**
	 * Get GMT Offset
	 *
	 * @param bool $in_seconds
	 * @param null $timestamp
	 *
	 * @return float|int
	 *
	 */
	public static function get_gmt_offset( $in_seconds = false, $timestamp = null ) {

		$offset = get_option( 'gmt_offset' );

		if ( $offset == '' ) {
			$tzstring = get_option( 'timezone_string' );
			$current  = date_default_timezone_get();
			date_default_timezone_set( $tzstring );
			$offset = date( 'Z' ) / 3600;
			date_default_timezone_set( $current );
		}

		// check if timestamp has DST
		if ( ! is_null( $timestamp ) ) {
			$l = localtime( $timestamp, true );
			if ( $l['tm_isdst'] ) {
				$offset ++;
			}
		}

		return $in_seconds ? $offset * 3600 : (int) $offset;
	}

	/**
	 * Insert $new in $array after $key
	 *
	 * @param $array
	 * @param $key
	 * @param $new
	 *
	 * @return array
	 *
	 */
	public static function array_insert_after( $array, $key, $new ) {
		$keys  = array_keys( $array );
		$index = array_search( $key, $keys );
		$pos   = false === $index ? count( $array ) : $index + 1;

		return array_merge( array_slice( $array, 0, $pos ), $new, array_slice( $array, $pos ) );
	}

	/**
	 * Insert a value or key/value pair before a specific key in an array.  If key doesn't exist, value is prepended
	 * to the beginning of the array.
	 *
	 * @param array $array
	 * @param string $key
	 * @param array $new
	 *
	 * @return array
	 */
	public static function array_insert_before( array $array, $key, array $new ) {
		$keys = array_keys( $array );
		$pos  = (int) array_search( $key, $keys );

		return array_merge( array_slice( $array, 0, $pos ), $new, array_slice( $array, $pos ) );
	}


	/**
	 * Insert $new in $array after $key
	 *
	 * @param $array
	 *
	 * @return boolean
	 *
	 */
	public static function is_forechable( $array = array() ) {

		if ( ! is_array( $array ) ) {
			return false;
		}

		if ( empty( $array ) ) {
			return false;
		}

		if ( count( $array ) <= 0 ) {
			return false;
		}

		return true;

	}

	/**
	 * Get current db version
	 *
	 * @since 1.0.0
	 */
	public static function get_db_version() {
		return Option::get( 'db_version', '0.0.1' );
	}

	/**
	 * Get all Plugin admin screens
	 *
	 * @return array|mixed|void
	 *
	 * @since 1.0.0
	 */
	public static function get_plugin_admin_screens() {

		// TODO: Can be updated with a version check when https://core.trac.wordpress.org/ticket/18857 is fixed
		$prefix = sanitize_title( __( 'URL Shortify', 'url-shortify' ) );

		$screens = array(
			'toplevel_page_url_shortify',
			"{$prefix}_page_us_links",
			"{$prefix}_page_us_groups",
			"{$prefix}_page_us_domains",
			"{$prefix}_page_us_utm_presets",
			"{$prefix}_page_us_tools",
			"{$prefix}_page_kc-us-settings",
			"{$prefix}_page_kc-us-tools-settings",
			"{$prefix}_page_url_shortify-account",
		);

		$screens = apply_filters( 'kc_us_admin_screens', $screens );

		return $screens;
	}

	/**
	 * Is es admin screen?
	 *
	 * @param string $screen_id Admin screen id
	 *
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	public static function is_plugin_admin_screen( $screen_id = '' ) {

		$current_screen_id = self::get_current_screen_id();
		// Check for specific admin screen id if passed.
		if ( ! empty( $screen_id ) ) {
			if ( $current_screen_id === $screen_id ) {
				return true;
			} else {
				return false;
			}
		}

		$plugin_admin_screens = self::get_plugin_admin_screens();

		if ( in_array( $current_screen_id, $plugin_admin_screens ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Get Current Screen Id
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public static function get_current_screen_id() {

		$current_screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;

		if ( ! $current_screen instanceof \WP_Screen ) {
			return '';
		}

		$current_screen = get_current_screen();

		return ( $current_screen ? $current_screen->id : '' );
	}

	/**
	 * Get data from array
	 *
	 * @param array $array
	 * @param string $var
	 * @param string $default
	 * @param bool $clean
	 *
	 * @return array|string
	 *
	 * @since 1.0.0
	 */
	public static function get_data( $array = array(), $var = '', $default = '', $clean = false ) {

		if ( empty( $array ) ) {
			return $default;
		}

		if ( ! empty( $var ) || ( 0 === $var ) ) {
			if ( strpos( $var, '|' ) > 0 ) {
				$vars = array_map('trim', explode( '|', $var ));
				foreach ( $vars as $var ) {
					if ( isset( $array[ $var ] ) ) {
						$array = $array[ $var ];
					} else {
						return $default;
					}
				}

				return wp_unslash( $array );
			} else {
				$value = isset( $array[ $var ] ) ? wp_unslash( $array[ $var ] ) : $default;
			}
		} else {
			$value = wp_unslash( $array );
		}

		if ( $clean ) {
			$value = self::clean( $value );
		}

		return $value;
	}

	/**
	 * Get POST | GET data from $_REQUEST
	 *
	 * @param string $var
	 * @param string $default
	 * @param bool $clean
	 *
	 * @return array|string
	 *
	 * @since 1.0.0
	 */
	public static function get_request_data( $var = '', $default = '', $clean = true ) {
		return self::get_data( $_REQUEST, $var, $default, $clean );
	}

	/**
	 * Get POST data from $_POST
	 *
	 * @param string $var
	 * @param string $default
	 * @param bool $clean
	 *
	 * @return array|string
	 *
	 * @since 1.0.0
	 */
	public static function get_post_data( $var = '', $default = '', $clean = true ) {
		return self::get_data( $_POST, $var, $default, $clean );
	}

	/**
	 * Get Current blog url with or without prefix.
	 *
	 * @return string
	 *
	 * @since 1.0.0
     *
     * @modified 1.5.12
	 */
	public static function get_blog_url( $with_prefix = false ) {
		$blog_id = null;
		if ( function_exists( 'is_multisite' ) && is_multisite() && function_exists( 'get_current_blog_id' ) ) {
			$blog_id = get_current_blog_id();
		}

		$blog_url = get_home_url( $blog_id );

		// Fix WPML adding the language code at the start of the URL
		if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			if ( empty( $prli_bid ) || ! function_exists( 'is_multisite' ) || ! is_multisite() ) {
				$blog_url = get_option( 'home' );
			} else {
				switch_to_blog( $prli_bid );
				$blog_url = get_option( 'home' );
				restore_current_blog();
			}
		}

		if ( $with_prefix ) {
			$prefix = self::get_link_prefix();
			if ( ! empty( $prefix ) ) {
				$blog_url = $blog_url . '/' . $prefix . '/';
			}
		}

		return $blog_url;
	}

    /**
     * Get slug with prefix.
     *
     * @param string $slug
     *
     * @return string
     *
     * @sicne 1.5.12
     */
    public static function get_slug_with_prefix( $slug = '' ) {
        if ( empty( $slug ) ) {
            return '';
        }

        $prefix = self::get_link_prefix();

        $slug = ltrim( $slug, $prefix );

		return ( empty($prefix) ? ltrim( $slug, '/' ) : trim( trim( $prefix, '/' ) . '/' . ltrim( $slug, '/' ) ) );
    }

    public static function get_link_prefix() {
        $settings = US()->get_settings();

        return Helper::get_data( $settings, 'links_default_link_options_link_prefix', '' );
    }

	/**
	 * Get short link
	 *
	 * @param string $slug
	 * @param array $link_data
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public static function get_short_link( $slug = '', $link_data = array() ) {

		if ( empty( $slug ) ) {
			return '';
		}

		$link = trailingslashit( self::get_blog_url() ) . $slug;

		if ( empty( $link_data ) || ! US()->is_pro() ) {
			return $link;
		}

		return apply_filters( 'kc_us_generate_short_link', $link, $slug, $link_data );
	}

	/**
	 * Get short link by link id
	 *
	 * @param string $id
	 *
	 * @return string
	 *
	 * @since 1.2.10
	 */
	public static function get_short_link_by_id( $id = '' ) {
		if ( empty( $id ) ) {
			return '';
		}

		$link = US()->db->links->get_by_id( $id );

		return self::get_short_link( $link['slug'], $link );
	}

	/**
	 * Get redirection types
	 *
	 * @return mixed|void
	 *
	 * @since 1.0.0
	 */
	public static function get_redirection_types() {

		$types = array(
			'307' => __( '307 (Temporary)', 'url-shortify' ),
			'302' => __( '302 (Temporary)', 'url-shortify' ),
			'301' => __( '301 (Permanent)', 'url-shortify' )
		);

		$additional_types = apply_filters( 'kc_us_redirection_types', array() );

		if ( is_array( $additional_types ) && count( $additional_types ) > 0 ) {
			$types = $types + $additional_types;
		}

		return $types;
	}

	/**
	 * Get link prefixes
	 *
	 * @return array
	 *
	 * @since 1.5.7
	 */
	public static function get_link_prefixes() {

		$types = array(
			''           => __( '-- No Prefix --', 'url-shortify' ),
			'recommends' => __( 'recommends', 'url-shortify' ),
			'go'         => __( 'go', 'url-shortify' ),
		);

		$additional_prefixes = apply_filters( 'kc_us_link_prefixes', array() );

		if ( is_array( $additional_prefixes ) && count( $additional_prefixes ) > 0 ) {
			$types = $types + $additional_prefixes;
		}

		return $types;
	}

	/**
	 * Get custom domains
	 *
	 * @return array|void
	 *
	 * @since 1.3.8
	 */
	public static function get_domains() {

		$domains = array(
			'home' => site_url(),
		);

		$custom_domains = apply_filters( 'kc_us_custom_domains', array() );

		if ( is_array( $custom_domains ) && count( $custom_domains ) > 0 ) {
			$domains = Helper::array_insert_before( $domains, 'home', array( 'any' => __( 'All my domains', 'url-shortify' ) ) );
			$domains = $domains + $custom_domains;
		}

		return $domains;
	}

	/**
	 * Create Copy Link HTML
	 *
	 * @param $link
	 * @param $id
	 * @param string $html
	 *
	 * @return string
	 *
	 * @since 1.1.3
	 */
	public static function create_copy_short_link_html( $link, $id, $html = '' ) {
		if ( ! empty( $html ) ) {
			return '<span class="kc-flex kc-us-copy-to-clipboard" data-clipboard-text="' . $link . '" id="link-' . $id . '">' . $html . '<svg class="kc-us-link-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><title>' . __( 'Copy',
					'url-shortify' ) . '</title><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg><p id="copied-text-link-' . $id . '"></p></span>';
		} else {
			return '<span class="kc-flex kc-us-copy-to-clipboard" data-clipboard-text="' . $link . '" id="link-' . $id . '"><svg class="kc-us-link-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><title>' . __( 'Copy',
					'url-shortify' ) . '</title><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg><p id="copied-text-link-' . $id . '"></p></span>';
		}
	}

	/**
	 * Create Link Stats URL
	 *
	 * @param int $link_id
	 *
	 * @return string|void
	 *
	 * @since 1.1.3
	 */
	public static function create_link_stats_url( $link_id = 0 ) {

		if ( empty( $link_id ) ) {
			return '#';
		}

		return self::get_link_action_url( $link_id, 'statistics' );
	}

	/**
	 * Prpare clicks column
	 *
	 * @param $link_ids
	 * @param string $stats_url
	 *
	 * @return string
	 *
	 * @since 1.1.3
	 *
	 * @modified 1.2.4
	 */
	public static function prepare_clicks_column( $link_ids, $stats_url = '' ) {

		$total_clicks  = Stats::get_total_clicks_by_link_ids( $link_ids );
		$unique_clicks = Stats::get_total_unique_clicks_by_link_ids( $link_ids );

		if ( 0 == $total_clicks || empty( $stats_url ) ) {
			return $unique_clicks . ' / ' . $total_clicks;
		} else {
			return '<a href="' . $stats_url . '"  title="' . __( 'Unique Clicks / Total Clicks', 'url-shortify' ) . '" class="kc-us-link"/>' . $unique_clicks . ' / ' . $total_clicks . '</a>';
		}

	}

	/**
	 * Get link action url
	 *
	 * @param null $link_id
	 * @param string $action
	 *
	 * @return string
	 *
	 * @since 1.1.5
	 */
	public static function get_link_action_url( $link_id = null, $action = 'edit' ) {
		if ( empty( $link_id ) || empty( $action ) ) {
			return '#';
		}

		return self::get_action_url( $link_id, 'links', $action );
	}

	/**
	 * Get Group action url
	 *
	 * @param null $group_id
	 * @param string $action
	 *
	 * @return string
	 *
	 * @since 1.1.7
	 */
	public static function get_group_action_url( $group_id = null, $action = 'edit' ) {
		if ( empty( $group_id ) || empty( $action ) ) {
			return '#';
		}

		return self::get_action_url( $group_id, 'groups', $action );
	}

	/**
     * Get max upload file size.
     *
	 * @return int
     *
     * @since 1.6.0
	 */
    public static function get_max_upload_size() {
        // Allowed maximum 5MB file size.
        return min( 5242880, wp_max_upload_size() );
    }

	/**
	 * Get Group action url
	 *
	 * @param null $group_id
	 * @param string $action
	 *
	 * @return string
	 *
	 * @since 1.3.8
	 */
	public static function get_domain_action_url( $id = null, $action = 'edit' ) {
		if ( empty( $id ) || empty( $action ) ) {
			return '#';
		}

		return self::get_action_url( $id, 'domains', $action );
	}

    /**
	 * Get UTM Presets action url
	 *
	 * @param null $group_id
	 * @param string $action
	 *
	 * @return string
	 *
	 * @since 1.3.8
	 */
	public static function get_utm_presets_action_url( $id = null, $action = 'edit' ) {
		if ( empty( $id ) || empty( $action ) ) {
			return '#';
		}

		return self::get_action_url( $id, 'utm_presets', $action );
	}

	/**
	 * Get action url
	 *
	 * @param null $id
	 * @param string $type
	 * @param string $action
	 *
	 * @return string
	 *
	 * @since 1.1.7
	 */
	public static function get_action_url( $id = null, $type = 'links', $action = 'edit' ) {
		if ( empty( $id ) || empty( $action ) ) {
			return '#';
		}

		if ( 'links' === $type ) {
			$page = 'us_links';
		} elseif ( 'groups' === $type ) {
			$page = 'us_groups';
		} elseif ( 'domains' === $type ) {
            $page = 'us_domains';
        } elseif('utm_presets' === $type) {
            $page = 'us_utm_presets';
		} else {
			$page = 'us_links';
		}

		$args = array(
			'page'     => $page,
			'id'       => $id,
			'action'   => $action,
			'_wpnonce' => wp_create_nonce( 'us_action_nonce' )
		);

		return add_query_arg( $args, admin_url( 'admin.php' ) );
	}

	/**
	 * Get Start & End date based on $days
	 *
	 * @param int $days
	 *
	 * @return array
	 *
	 * @since 1.1.6
	 */
	public static function get_start_and_end_date_from_last_days( $days = 7 ) {
		$end_date = date( 'Y-m-d', time() );

		$start_date = date( 'Y-m-d', strtotime( "- $days days" ) );

		return array(
			'start_date' => $start_date,
			'end_date'   => $end_date
		);
	}

	/**
	 * Return string with specific length
	 *
	 * @param $x
	 * @param $length
	 *
	 * @return string
	 *
	 * @since 1.2.0
	 */
	public static function str_limit( $x, $length ) {
		if ( strlen( $x ) <= $length ) {
			return $x;
		} else {
			$y = substr( $x, 0, $length ) . '...';

			return $y;
		}
	}

	/**
	 * Get Post Type from Post ID
	 *
	 * @param int $cpt_id
	 *
	 * @return string
	 *
	 * @since 1.2.5
	 */
	public static function get_cpt_type_from_cpt_id( $cpt_id = 0 ) {

		if ( empty( $cpt_id ) ) {
			return '';
		}

		$post = get_post( $cpt_id );

		if ( $post instanceof \WP_Post ) {

			return $post->post_type;
		}

		return '';
	}

	/**
	 * Get CPT Info
	 *
	 * @param string $cpt_type
	 *
	 * @return array
	 *
	 * @since 1.2.5
	 */
	public static function get_cpt_info( $cpt_type = '' ) {

		$cpt_info = array(

			'post' => array(
				'title' => __( 'Post', 'url-shortify' ),
				'icon'  => KC_US_PLUGIN_ASSETS_DIR_URL . '/images/cpt/post-24x24.png'
			),

			'page' => array(
				'title' => __( 'Page', 'url-shortify' ),
				'icon'  => KC_US_PLUGIN_ASSETS_DIR_URL . '/images/cpt/page-24x24.png'
			),

			'product' => array(
				'title' => __( 'WooCommerce', 'url-shortify' ),
				'icon'  => KC_US_PLUGIN_ASSETS_DIR_URL . '/images/cpt/woocommerce-24x24.png'
			),

			'download' => array(
				'title' => __( 'Easy Digital Download', 'url-shortify' ),
				'icon'  => KC_US_PLUGIN_ASSETS_DIR_URL . '/images/cpt/download-24x24.png'
			),

			'event' => array(
				'title' => __( 'Events Manager', 'url-shortify' ),
				'icon'  => KC_US_PLUGIN_ASSETS_DIR_URL . '/images/cpt/event-24x24.png'
			),

			'tribe_events' => array(
				'title' => __( 'The Events Calendar', 'url-shortify' ),
				'icon'  => KC_US_PLUGIN_ASSETS_DIR_URL . '/images/cpt/tribe_events-24x24.png'
			),

			'docs' => array(
				'title' => __( 'Betterdocs', 'url-shortify' ),
				'icon'  => KC_US_PLUGIN_ASSETS_DIR_URL . '/images/cpt/docs-24x24.png'
			),

			'kbe_knowledgebase' => array(
				'title' => __( 'WordPress Knowledgebase', 'url-shortify' ),
				'icon'  => KC_US_PLUGIN_ASSETS_DIR_URL . '/images/cpt/kbe_knowledgebase-24x24.png'
			),

			'mec-events' => array(
				'title' => __( 'Modern Events', 'url-shortify' ),
				'icon'  => KC_US_PLUGIN_ASSETS_DIR_URL . '/images/cpt/mec-events-24x24.png'
			),

		);

		return ! empty( $cpt_info[ $cpt_type ] ) ? $cpt_info[ $cpt_type ] : $cpt_info['post'];
	}

	public static function get_all_cpt_data() {
		return get_post_types( array( '_builtin' => false, 'public' => true ), 'objects', 'and' );
	}

	/**
	 * Check whether ip fall into excluded ips
	 *
	 * @param $ip
	 * @param $range
	 *
	 * @return bool
	 *
	 * @since 1.3.0
	 */
	public static function is_ip_in_range( $ip, $range ) {

		$ip    = trim( $ip );
		$range = trim( $range );

		if ( $ip === $range ) {
			return true;
		}

		if ( strpos( $range, '/' ) !== false ) {
			// $range is in IP/NETMASK format
			list( $range, $netmask ) = explode( '/', $range, 2 );
			if ( strpos( $netmask, '.' ) !== false ) {
				// $netmask is a 255.255.0.0 format
				$netmask     = str_replace( '*', '0', $netmask );
				$netmask_dec = ip2long( $netmask );

				return ( ( ip2long( $ip ) & $netmask_dec ) == ( ip2long( $range ) & $netmask_dec ) );
			} else {
				// $netmask is a CIDR size block
				// fix the range argument
				$x = explode( '.', $range );
				while ( count( $x ) < 4 ) {
					$x[] = '0';
				}
				list( $a, $b, $c, $d ) = $x;
				$range     = sprintf( "%u.%u.%u.%u", empty( $a ) ? '0' : $a, empty( $b ) ? '0' : $b, empty( $c ) ? '0' : $c, empty( $d ) ? '0' : $d );
				$range_dec = ip2long( $range );
				$ip_dec    = ip2long( $ip );

				# Strategy 1 - Create the netmask with 'netmask' 1s and then fill it to 32 with 0s
				#$netmask_dec = bindec(str_pad('', $netmask, '1') . str_pad('', 32-$netmask, '0'));

				# Strategy 2 - Use math to create it
				$wildcard_dec = pow( 2, ( 32 - $netmask ) ) - 1;
				$netmask_dec  = ~$wildcard_dec;

				return ( ( $ip_dec & $netmask_dec ) == ( $range_dec & $netmask_dec ) );
			}
		} else {
			// range might be 255.255.*.* or 1.2.3.0-1.2.3.255
			if ( strpos( $range, '*' ) !== false ) { // a.b.*.* format
				// Just convert to A-B format by setting * to 0 for A and 255 for B
				$lower = str_replace( '*', '0', $range );
				$upper = str_replace( '*', '255', $range );
				$range = "$lower-$upper";
			}

			if ( strpos( $range, '-' ) !== false ) { // A-B format
				list( $lower, $upper ) = explode( '-', $range, 2 );
				$lower_dec = (float) sprintf( "%u", ip2long( $lower ) );
				$upper_dec = (float) sprintf( "%u", ip2long( $upper ) );
				$ip_dec    = (float) sprintf( "%u", ip2long( $ip ) );

				return ( ( $ip_dec >= $lower_dec ) && ( $ip_dec <= $upper_dec ) );
			}


			return false;
		}

	}

	/**
	 * Prpeare Social share widget
	 *
	 * @param null $link_id
	 * @param string $share_icon_size
	 *
	 * @return string
	 *
	 * @since 1.3.2
	 */
	public static function get_social_share_widget( $link_id = null, $share_icon_size = '1' ) {

		$html = '';

		$socials = array();

		$socials = apply_filters( 'kc_us_filter_social_sharing', $socials, $link_id );

		if ( Helper::is_forechable( $socials ) ) {

			$html .= '<div class="share-button sharer pointer" style="display: block;">';
			$html .= '<span class="fa fa-share-alt text-indigo-600 fa-' . $share_icon_size . 'x share-btn cursor-pointer"></span>';
			$html .= '<div class="social bottom center networks-5 us-social" >';

			foreach ( $socials as $social => $data ) {

				$url   = Helper::get_data( $data, 'url', '' );
				$icon  = Helper::get_data( $data, 'icon', '' );
				$title = Helper::get_data( $data, 'title', '' );

				$html .= sprintf( '<a class="fbtn share %s" href="%s" title="%s" target="_blank">%s</i></a>', $social, $url, $title, $icon );
			}

			$html .= '</div></div>';
		}

		return $html;
	}

	/**
	 * Check Pretty Links Exists
	 *
	 * @return bool|int
	 *
	 * @since 1.3.4
	 */
	public static function is_pretty_links_table_exists() {
		global $wpdb;

		$links_table = "{$wpdb->prefix}prli_links";

		return US()->is_table_exists( $links_table );
	}

	/**
	 * Check MTS Short Links Exists
	 *
	 * @return bool|int
	 *
	 * @since 1.3.4
	 */
	public static function is_mts_short_links_table_exists() {
		global $wpdb;

		$links_table = "{$wpdb->prefix}short_links";

		return US()->is_table_exists( $links_table );
	}

	/**
	 * Check Easy 301 Redirect Plugin Installed
	 *
	 * @return bool|int
	 *
	 * @since 1.3.4
	 */
	public static function is_301_redirect_table_exists() {
		global $wpdb;

		$links_table = "{$wpdb->prefix}redirects";

		return US()->is_table_exists( $links_table );
	}

	/**
	 * Check Simple 301 Redirect plugin installed
	 *
	 * @return bool
	 *
	 * @since 1.4.8
	 */
	public static function is_simple_301_redirect_plugin_installed() {
		$plugins = Tracker::get_active_plugins();

		if ( in_array( 'simple-301-redirects/wp-simple-301-redirects.php', $plugins ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check Simple 301 Redirect plugin installed
	 *
	 * @return bool
	 *
	 * @since 1.4.8
	 */
	public static function is_thirstry_affiliates_installed() {
		$plugins = Tracker::get_active_plugins();

		if ( in_array( 'thirstyaffiliates/thirstyaffiliates.php', $plugins ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check Shorten URL Plugin Installed
	 *
	 * @return bool|int
	 *
	 * @since 1.3.4
	 */
	public static function is_shorten_url_table_exists() {
		global $wpdb;

		$links_table = "{$wpdb->prefix}pluginSL_shorturl";

		return US()->is_table_exists( $links_table );
	}

	/**
	 * Gets the current action selected from the bulk actions dropdown.
	 *
	 * @return string|false The action name. False if no action was selected.
	 * @since 1.3.4
	 *
	 */
	public static function get_current_action() {
		if ( isset( $_REQUEST['filter_action'] ) && ! empty( $_REQUEST['filter_action'] ) ) {
			return false;
		}

		if ( isset( $_REQUEST['action'] ) && - 1 != $_REQUEST['action'] ) {
			return $_REQUEST['action'];
		}

		if ( isset( $_REQUEST['action2'] ) && - 1 != $_REQUEST['action2'] ) {
			return $_REQUEST['action2'];
		}

		return false;
	}

	/**
	 * Get group string
	 *
	 * @param $group_ids
	 * @param $groups
	 *
	 * @return string
	 *
	 * @since 1.3.7
	 */
	public static function get_group_str_from_ids( $group_ids, $groups ) {
		if ( empty( $group_ids ) ) {
			return '';
		}

		if ( is_int( $group_ids ) ) {
			$group_ids = array( $group_ids );
		}

		if ( empty( $groups ) ) {
			$groups = US()->db->groups->get_id_name_map();
		}

		$group_str = array();
		foreach ( $group_ids as $group_id ) {
			$group_str[] = Helper::get_data( $groups, $group_id, '' );
		}

		return implode( ', ', $group_str );
	}

	/**
	 * Is shortlink request coming from same domain
	 *
	 * @return bool
	 *
	 * @sicne 1.3.8
	 */
	public static function is_request_from_same_domain() {

		$site_url = get_site_url();

		return self::is_request_from_specific_domain( $site_url );
	}

	/**
	 * Is request coming from specific domain?
	 *
	 * @param $domain
	 *
	 * @return bool
	 *
	 * @since 1.3.8
	 */
	public static function is_request_from_specific_domain( $domain ) {

		$current_page_url = Utils::get_current_page_url();

		$clean_site_host    = Utils::get_the_clean_domain( $domain );
		$clean_request_host = Utils::get_the_clean_domain( $current_page_url );

		return $clean_site_host === $clean_request_host;

	}

	/**
	 * Can show promotion message?
	 *
	 * @param array $meta
	 * @param string $check_plan
	 *
	 * @return bool
	 *
	 * @since 1.4.4
	 */
	public static function can_show_promotion($conditions = array()) {

		$conditions = array_merge(
			array(
				'check_plan'                    => 'pro',
				'meta'                          => array(),
				'start_after_installation_days' => 7,
				'end_before_installation_days'  => 999999,
				'total_links'                   => 2,
				'start_date'                    => null,
				'end_date'                      => null,
				'promotion'                     => null
			), $conditions
		);

        extract($conditions);

		if ( 'pro' === $check_plan ) {
			if ( US()->is_pro() ) {
				return false;
			}
		}

        // Already seen this promotion?
		if ( ! is_null( $promotion ) && self::is_promotion_dismissed( $promotion ) ) {
			return false;
		}

		$today = Helper::get_current_date_time();

        // Don't show if start date is future.
		if ( ! is_null( $start_date ) && ( $today < $start_date ) ) {
			return false;
		}

        // Don't show if end date is past.
		if ( ! is_null( $end_date ) && ( $today > $end_date ) ) {
			return false;
		}
        // Check total links condition if it exists.
		if ( ! is_null( $total_links ) ) {
			if ( $total_links > US()->db->links->count() ) {
				return false;
			}
		}

		$installed_on = Option::get( 'installed_on', 0 );
		if ( 0 === $installed_on ) {
			Option::set( 'installed_on', time() );
		}

		$since_installed = ceil( ( time() - $installed_on ) / 86400 );

		if ( $since_installed >= $start_after_installation_days && $since_installed <= $end_before_installation_days ) {
			return true;
		}

		return false;
	}

	/**
	 * Prepare Tooltip html
	 *
	 * @param string $tooltip_text
	 *
	 * @return string
	 *
	 * @since 1.4.7
	 */
	public static function get_tooltip_html( $tooltip_text = '' ) {

		$tooltip_html = '';
		if ( ! empty( $tooltip_text ) ) {
			$tooltip_html = '<div class="inline-block kc-us-tooltip relative align-middle cursor-pointer ml-1 mb-1">
				<svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
				<span class="break-words invisible rounded-lg h-auto lg:w-48 xl:w-64 tracking-wide absolute z-70 kc-us-tooltip-text bg-black text-gray-300 text-xs rounded p-3 py-2">
					' . $tooltip_text . '
					<svg class="absolute mt-2 text-black text-opacity-100 h-2.5 left-0" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
						<polygon class="fill-current" points="0,0 127.5,127.5 255,0"/>
					</svg>
				</span>
			</div>';
		}

		return $tooltip_html;
	}

	/**
	 * Can tools submenu menu visible.
	 *
	 * @return bool
	 *
	 * @since 1.5.9
	 */
	public static function can_show_tools_menu() {
		return true;
	}

	/**
	 * Get links json filename
	 *
	 * @return string
	 *
	 * @since 1.5.1
	 */
	public static function get_links_json_filename() {
		$hash = Option::get( 'plugin_secret' );

		return 'links-' . $hash . '.json';
	}

	/**
	 * Is links json file exists
	 *
	 * @return bool
	 *
	 * @since 1.5.1
	 */
	public static function is_links_json_file_exists() {
		$links_json_file = self::get_links_json_filename();

		return file_exists( KC_US_UPLOADS_DIR . $links_json_file );
	}

	/**
	 * Get all links from Json
	 *
	 * @return mixed
	 *
	 * @since 1.5.1
	 */
	public static function get_links_from_json() {
		$links_json_file = self::get_links_json_filename();

		return json_decode( file_get_contents( KC_US_UPLOADS_DIR . $links_json_file ), true );
	}

	/**
	 * Get link data based on request uri
	 *
	 * @param string $request_uri
	 *
	 * @return array|bool|data|object|string|null
	 *
	 * @since 1.5.1
	 */
	public static function get_link_data( $request_uri = '' ) {

        $request_uri = trim( $request_uri, '/' );
        /*
		if ( self::is_links_json_file_exists() ) {
			$links_data = self::get_links_from_json();

			if ( isset( $links_data[ $request_uri ] ) ) {
				return self::get_data( $links_data, $request_uri, array() );
			}
		}
        */

		// Even if JSON file exists but if the short URL is not there, check in the database.
		return US()->db->links->get_by_slug( $request_uri );
	}

	/**
	 * Get link data if is short link
	 *
	 * @param $url
	 * @param bool $check_domain
	 *
	 * @return array|bool
	 *
	 * @since 1.5.0
	 */
	public static function is_us_link( $url, $check_domain = true ) {

		$blog_url = Helper::get_blog_url();

		if ( ! $check_domain || preg_match( '#^' . preg_quote( $blog_url ) . '#', $url ) ) {

			$uri = preg_replace( '#' . preg_quote( $blog_url ) . '#', '', $url );

			// Resolve WP installs in sub-directories
			preg_match( '#^(https?://.*?)(/.*)$#', $blog_url, $sub_directory );

			$struct = Utils::get_permalink_pre_slug_regex();

			$subdir_str = ( isset( $sub_directory[2] ) ? $sub_directory[2] : '' );

			$match_str = '#^' . $subdir_str . '(' . $struct . ')([^\?]*?)([\?].*?)?$#';

			if ( preg_match( $match_str, $uri, $match_val ) ) {
				// Match longest slug -- this is the most common
				$params = ( isset( $match_val[3] ) ? $match_val[3] : '' );

				if ( $link = self::get_link_data( $match_val[2] ) ) {
					return $link;
				}

				// Trim down the matched link
				$matched_link = preg_replace( '#/[^/]*?$#', '', $match_val[2], 1 );

				for ( $i = 0; ( $i < 25 ) && ! empty( $matched_link ) && ( $matched_link != $match_val[2] ); $i ++ ) {

					$new_match_str = "#^{$subdir_str}({$struct})({$matched_link})(.*?)?$#";

					$params = ( isset( $match_val[3] ) ? $match_val : '' );

					if ( $link = self::get_link_data( $match_val[2] ) ) {
						return $link;
					}

					// Trim down the matched link and try again
					$matched_link = preg_replace( '#/[^/]*$#', '', $match_val[2], 1 );
				}
			}
		}
		return false;
	}

	/**
	 * Regenerate JSON links
	 *
	 * @since 1.5.1
	 */
	public static function regenerate_json_links() {
		$links = US()->db->links->get_all();

		$links_data = array();
		if ( self::is_forechable( $links ) ) {

			foreach ( $links as $link ) {
				$links_data[ $link['slug'] ] = array(
					'id'                => $link['id'],
					'slug'              => $link['slug'],
					'url'               => $link['url'],
					'nofollow'          => $link['nofollow'],
					'track_me'          => $link['track_me'],
					'sponsored'         => $link['sponsored'],
					'params_forwarding' => $link['params_forwarding'],
					'params_structure'  => $link['params_structure'],
					'redirect_type'     => $link['redirect_type'],
					'status'            => $link['status'],
					'type'              => $link['type'],
					'password'          => $link['password'],
					'expires_at'        => $link['expires_at'],
					'rules'             => maybe_unserialize( $link['rules'] ),
				);
			}

		}

		$links_json_file = self::get_links_json_filename();

		return file_put_contents( KC_US_UPLOADS_DIR . "/" . $links_json_file, json_encode( $links_data ) );
	}

	/**
	 * Generate short url based on provided or default settings.
	 *
	 * @param $url
	 * @param array $settings
	 *
	 * @return string
	 */
	public static function generate_short_link($url, $settings = array()) {
		$short_url = '';

		return $short_url;
	}

	/**
     * Get upgrade banner.
     *
	 * @return void
     *
     * @since 1.5.15
	 */
	public static function get_upgrade_banner($query_strings = array(), $show_coupon = false) {


		// $message = __('Your plugin plan is limited to 1 week of historical data. Upgrade your plan to see all historical data.', 'url-shortify');
		// $coupon_message = printf( __( 'Use coupon code <b class="bg-indigo-600 px-1 py-1 text-xl">%s</b> to get flat <b class="text-2xl">$30</b> off on any plan', 'url-shortify' ), 'WELCOME30' );
		$message = __('Be one of the first 100 customers to snag incredible discounts and join in the festivities as we celebrate our 3rd anniversary!', 'url-shortify');
		$coupon_message = sprintf( __( 'Use coupon code <b class="bg-indigo-600 px-1 py-1 text-xl">%s</b> to get flat <b class="text-2xl">%s</b> off on single-site lifetime license.', 'url-shortify' ), 'LIFETIME', '$100' );

		?>
        <div class="bg-red-500">
            <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between flex-wrap">
                    <div class="w-0 flex-1 flex items-center">
                        <p class="ml-3 font-medium text-white truncate">
                            <span class="text-base">
                                 <?php echo $message; ?>

	                            <?php if ( $show_coupon ) { ?>
                                    <br/>
                                <?php echo $coupon_message; } ?>
                            </span>
                        </p>
                    </div>
                    <div class="order-3 mt-2 flex-shrink-0 w-full sm:order-2 sm:mt-0 sm:w-auto">
                        <a href="<?php echo esc_url( add_query_arg($query_strings, US()->get_landing_page_url()) ); ?>" class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-500 hover:bg-indigo-50"><?php _e('Upgrade Now', 'url-shortify'); ?><span aria-hidden="true">&nbsp;&rarr;</span></a>
                    </div>
                    <?php if($show_coupon) { ?>
                    <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3">
                        <a href="<?php echo esc_url( add_query_arg($query_strings, US()->get_landing_page_url()) ); ?>">
                            <button type="button" class="-mr-1 flex p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-white sm:-mr-2">
                                <span class="sr-only">Dismiss</span>
                                <!-- Heroicon name: outline/x -->
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </a>
                    </div>
			        <?php } ?>
                </div>
            </div>
        </div>


		<?php
	}

	/**
     * Is promotion dismissed?
     *
	 * @param $promotion
	 *
	 * @return bool
     *
     * @since 1.5.15
	 */
	public static function is_promotion_dismissed($promotion) {
		if(empty($promotion)) {
			return false;
		}

		$promotion_dismissed_option = 'kc_us_' . trim($promotion) . '_dismissed';

		return 'yes' === get_option($promotion_dismissed_option);
	}

	/**
     * Prepare group dropdown options.
     *
	 * @param $selected
	 * @param $default_label
	 *
	 * @return string
     *
     * @since 1.6.1
	 */
	public static function prepare_group_dropdown_options( $selected = '', $default_label = 'Select Group' ) {

		$default_option[0] = __( $default_label, 'url-shortify' );

		$groups = US()->db->groups->get_id_name_map();

		$groups = $default_option + $groups;

		$dropdown = '';

		if ( is_string( $selected ) && strpos( $selected, ',' ) > 0 ) {
			$selected = explode( ',', $selected );
		}

		foreach ( $groups as $key => $group ) {

			$dropdown .= '<option value="' . esc_attr( $key ) . '" ';

			if ( is_array( $selected ) ) {
				if ( in_array( $key, $selected ) ) {
					$dropdown .= 'selected = selected';
				}
			} else {
				if ( ! empty( $selected ) && $selected == $key ) {
					$dropdown .= 'selected = selected';
				}
			}

			$dropdown .= '>' . esc_html( $group ) . '</option>';
		}

		return $dropdown;
	}

	/**
     * Allowed HTML Tags esc function.
     *
	 * @return array
     *
     * @since 1.6.1
	 */
	public static function allowed_html_tags_in_esc() {
		$context_allowed_tags = wp_kses_allowed_html( 'post' );
		$custom_allowed_tags  = array(
			'div'      => array(
				'x-data' => true,
				'x-show' => true,
			),
			'select'   => array(
				'class'    => true,
				'name'     => true,
				'id'       => true,
				'style'    => true,
				'title'    => true,
				'role'     => true,
				'data-*'   => true,
				'tab-*'    => true,
				'multiple' => true,
				'aria-*'   => true,
				'disabled' => true,
				'required' => 'required',
			),
			'optgroup' => array(
				'label' => true,
			),
			'option'   => array(
				'class'    => true,
				'value'    => true,
				'selected' => true,
				'name'     => true,
				'id'       => true,
				'style'    => true,
				'title'    => true,
				'data-*'   => true,
			),
			'input'    => array(
				'class'          => true,
				'name'           => true,
				'type'           => true,
				'value'          => true,
				'id'             => true,
				'checked'        => true,
				'disabled'       => true,
				'selected'       => true,
				'style'          => true,
				'required'       => 'required',
				'min'            => true,
				'max'            => true,
				'maxlength'      => true,
				'size'           => true,
				'placeholder'    => true,
				'autocomplete'   => true,
				'autocapitalize' => true,
				'autocorrect'    => true,
				'tabindex'       => true,
				'role'           => true,
				'aria-*'         => true,
				'data-*'         => true,
			),
			'label'    => array(
				'class' => true,
				'name'  => true,
				'type'  => true,
				'value' => true,
				'id'    => true,
				'for'   => true,
				'style' => true,
			),
			'form'     => array(
				'class'  => true,
				'name'   => true,
				'value'  => true,
				'id'     => true,
				'style'  => true,
				'action' => true,
				'method' => true,
				'data-*' => true,
			),
			'svg'      => array(
				'width'    => true,
				'height'   => true,
				'viewbox'  => true,
				'xmlns'    => true,
				'class'    => true,
				'stroke-*' => true,
				'fill'     => true,
				'stroke'   => true,
			),
			'path'     => array(
				'd'               => true,
				'fill'            => true,
				'class'           => true,
				'fill-*'          => true,
				'clip-*'          => true,
				'stroke-linecap'  => true,
				'stroke-linejoin' => true,
				'stroke-width'    => true,
				'fill-rule'       => true,
			),

			'main'     => array(
				'align'    => true,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => true,
				'aria-*'   => true,
				'class'    => true,
				'id'       => true,
				'style'    => true,
				'title'    => true,
				'role'     => true,
				'data-*'   => true,
			),
			'textarea' => array(
				'autocomplete' => true,
				'required'     => 'required',
				'placeholder'  => true,
			),
			'style'    => array(),
			'link'     => array(
				'rel'   => true,
				'id'    => true,
				'href'  => true,
				'media' => true,
			),
			'a'        => array(
				'x-on:click' => true,
			),
			'polygon'  => array(
				'class'  => true,
				'points' => true,
			),
		);

		return array_merge_recursive( $context_allowed_tags, $custom_allowed_tags );
	}
}
