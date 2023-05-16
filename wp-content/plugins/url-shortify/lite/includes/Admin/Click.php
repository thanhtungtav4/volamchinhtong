<?php

namespace Kaizen_Coders\Url_Shortify\Admin;

use Kaizen_Coders\Url_Shortify\Admin\DB\Clicks;
use Kaizen_Coders\Url_Shortify\Common\Browser;
use Kaizen_Coders\Url_Shortify\Common\GeoLocation;
use Kaizen_Coders\Url_Shortify\Helper;

/**
 * Class Click
 *
 * @since 1.0.2
 * @package Kaizen_Coders\Url_Shortify\Admin
 *
 */
class Click {

	/**
	 * @since 1.0.2
	 * @var array|int
	 *
	 */
	public $link_id = 0;

	/**
	 * @since 1.0.2
	 * @var Clicks|null
	 *
	 */
	public $db = null;

	/**
	 * @since 1.0.2
	 * @var string
	 *
	 */
	public $slug = null;

	/**
	 * @since 1.0.2
	 * @var string|null
	 *
	 */
	public $uri = null;

	/**
	 * @since 1.0.2
	 * @var null
	 *
	 */
	public $host = null;

	/**
	 * @since 1.0.2
	 * @var null
	 *
	 */
	public $referer = null;

	/**
	 * @since 1.0.2
	 * @var int
	 *
	 */
	public $is_first_click = 0;

	/**
	 * @since 1.0.2
	 * @var int
	 *
	 */
	public $is_robot = 0;

	/**
	 * @since 1.0.2
	 * @var null
	 *
	 */
	public $user_agent = null;

	/**
	 * @since 1.0.2
	 * @var null
	 *
	 */
	public $os = null;

	/**
	 * @since 1.0.2
	 * @var null
	 *
	 */
	public $device = null;

	/**
	 * @since 1.0.2
	 * @var null
	 *
	 */
	public $browser_type = null;

	/**
	 * @since 1.0.2
	 * @var null
	 *
	 */
	public $browser_version = null;

	/**
	 * @since 1.0.2
	 * @var null
	 *
	 */
	public $visitor_id = null;

	/**
	 * @since 1.0.2
	 * @var null
	 *
	 */
	public $country = null;

	/**
	 * @since 1.0.2
	 * @var null
	 *
	 */
	public $ip = null;

	/**
	 * @since 1.0.2
	 * @var null
	 *
	 */
	public $created_at = null;

	/**
	 * Click constructor.
	 *
	 * @param null $link_id
	 * @param null $slug
	 *
	 * @since 1.0.2
	 */
	public function __construct( $link_id = null, $slug = null ) {

		$this->link_id = $link_id;
		$this->slug    = $slug;
		$this->db      = new Clicks();

		$browser = new Browser();

		$this->is_first_click = 0;

		$this->ip = Helper::get_ip();

		try {

			$geo_data = GeoLocation::geolocate_ip( $this->ip, true );

			$country = Helper::get_data( $geo_data, 'country', '' );

		} catch ( \Exception $e ) {
			$country = null;
		}

		$this->country = $country;

		$this->referer = Helper::get_data( $_SERVER, 'HTTP_REFERER', '', true );
		$this->uri     = Helper::get_data( $_SERVER, 'REQUEST_URI', '', true );

		$this->user_agent = $browser->getUserAgent();

		$this->browser_type    = $browser->getBrowser();
		$this->browser_version = $browser->getVersion();
		$this->host            = gethostbyaddr( $this->ip );

		$this->is_robot = $browser->isRobot();
		$this->os       = $browser->getPlatform();

		$device = 'Desktop';
		if ( $browser->isMobile() ) {
			$device = 'Mobile';
		} elseif ( $browser->isTablet() ) {
			$device = 'Tablet';
		}

		$this->device = $device;

	}

	/**
	 * Track link clicks
	 *
	 * @since 1.0.2
	 */
	public function track() {

		// Set First Click
		$cookie_name        = 'kc_us_click_' . $this->link_id;
		$cookie_expire_time = time() + 60 * 60 * 24 * 30; // Expire in 30 days
		if ( ! isset( $_COOKIE[ $cookie_name ] ) ) {
			setcookie( $cookie_name, $this->slug, $cookie_expire_time, '/' );
			$this->is_first_click = 1;
		}

		// Set Visitor Cookie
		$visitor_cookie             = 'kc_us_visitor';
		$visitor_cookie_expire_time = time() + 60 * 60 * 24 * 365; // Expire in 1 year
		if ( ! isset( $_COOKIE[ $visitor_cookie ] ) ) {
			$this->visitor_id = $this->generate_unique_visitor_id();
			setcookie( $visitor_cookie, $this->visitor_id, $visitor_cookie_expire_time, '/' );
		} else {
			$this->visitor_id = $_COOKIE[ $visitor_cookie ];
		}

		$this->created_at = Helper::get_current_date_time();

		// Saving
		$this->save();
	}

	/**
	 * Generate unique id
	 *
	 * @return string
	 *
	 * @since 1.0.2
	 */
	public function generate_unique_visitor_id() {
		return uniqid();
	}

	/**
	 * Save tracking data
	 *
	 * @since 1.0.2
	 */
	public function save() {

		$defaults_data = $this->db->get_column_defaults();

		$data = array();
		foreach ( $defaults_data as $column => $value ) {
			if ( property_exists( $this, $column ) ) {
				$data[ $column ] = $this->$column;
			} else {
				$data[ $column ] = $value;
			}
		}

		$data = apply_filters( 'kc_us_clicks_data', $data, $this->link_id );

		$this->db->save( $data );
	}

}
