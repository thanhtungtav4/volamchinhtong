<?php
/**
 * WordPress Settings Framework
 *
 * @author  Gilbert Pellegrom, James Kemp
 * @link    https://github.com/gilbitron/WordPress-Settings-Framework
 * @license MIT
 */

/**
 * Define your settings
 *
 * The first parameter of this filter should be wpsf_register_settings_[options_group],
 * in this case "my_example_settings".
 *
 * Your "options_group" is the second param you use when running new WordPressSettingsFramework()
 * from your init function. It's important as it differentiates your options from others.
 *
 * To use the tabbed example, simply change the second param in the filter below to 'wpsf_tabbed_settings'
 * and check out the tabbed settings function on line 156.
 */

use Kaizen_Coders\Url_Shortify\Helper;

add_filter( 'wpsf_register_settings_kc_us', 'wpsf_tabbed_settings' );

/**
 * Settings
 *
 * @param $wpsf_settings
 *
 * @return mixed
 *
 * @since 1.0.0
 */
function wpsf_tabbed_settings( $wpsf_settings ) {

	// Tabs
	$tabs = array(

		array(
			'id'    => 'general',
			'title' => __( 'General', 'url-shortify' ),
		),

		array(
			'id'    => 'links',
			'title' => __( 'Links', 'url-shortify' ),
			'order' => 2
		),

		array(
			'id'    => 'reports',
			'title' => __( 'Reports', 'url-shortify' ),
			'order' => 3
		),

	);

	$wpsf_settings['tabs'] = apply_filters( 'kc_us_filter_settings_tab', $tabs );

	$redirection_types = Helper::get_redirection_types();

	// $link_prefixes = Helper::get_link_prefixes();

	$default_link_options = array(
		array(
			'id'      => 'redirection_type',
			'title'   => __( 'Redirection', 'url-shortify' ),
			'desc'    => '',
			'type'    => 'select',
			'default' => '307',
			'choices' => $redirection_types
		),

		array(
			'id'      => 'link_prefix',
			'title'   => __( 'Link Prefix', 'url-shortify' ),
            'desc'    => sprintf( __( "The prefix that comes before your short link's slug. <br>eg. %s/<strong>go</strong>/short-slug.<br><br><b>Note: </b>Link prefix will be added to all the new short links generated now onwards. It won't add prefix to existing links." , 'url-shortify' ) , home_url() ),
			'type'    => 'text',
			'default' => '',
		),

		array(
			'id'      => 'enable_nofollow',
			'title'   => __( 'Nofollow', 'url-shortify' ),
			'desc'    => '',
			'type'    => 'switch',
			'default' => 1,
		),

		array(
			'id'      => 'enable_sponsored',
			'title'   => __( 'Sponsored', 'url-shortify' ),
			'desc'    => '',
			'type'    => 'switch',
			'default' => 0,
		),

		array(
			'id'      => 'enable_paramter_forwarding',
			'title'   => __( 'Parameter Forwarding', 'url-shortify' ),
			'desc'    => '',
			'type'    => 'switch',
			'default' => 0,
		),

		array(
			'id'      => 'enable_tracking',
			'title'   => __( 'Tracking', 'url-shortify' ),
			'desc'    => '',
			'type'    => 'switch',
			'default' => 1,
		),

	);

	$default_link_options = apply_filters( 'kc_us_filter_default_link_options', $default_link_options );

	$general_options = array();

	$general_options = apply_filters( 'kc_us_filter_default_general_options', $general_options );

	$general_options[] = array(
		'id'      => 'delete_plugin_data',
		'title'   => __( 'Remove Data on Uninstall', 'url-shortify' ),
		'desc'    => __( 'Check this box if you would like to remove all data when plugin is deleted.', 'url-shortify' ),
		'type'    => 'checkbox',
		'default' => 0,
	);

	$default_reporting_options[] = array(
		'id'      => 'how_to_get_ip',
		'title'   => __( 'How does URL Shortify get IPs?', 'url-shortify' ),
		'type'    => 'radio',
		'choices' => array(
			''                      => __( 'Let URL Shortify use the most secure method to get visitor IP addresses. Prevents spoofing and works with most sites. <b>(Recommended)</b>', 'url-shortify' ),
			'REMOTE_ADDR'           => __( 'Use PHP\'s built in REMOTE_ADDR and don\'t use anything else. Very secure if this is compatible with your site.', 'url-shortify' ),
			'HTTP_X_FORWARDED_FOR'  => __( 'Use the X-Forwarded-For HTTP header. Only use if you have a front-end proxy or spoofing may result.', 'url-shortify' ),
			'HTTP_X_REAL_IP'        => __( 'Use the X-Real-IP HTTP header. Only use if you have a front-end proxy or spoofing may result.', 'url-shortify' ),
			'HTTP_CF_CONNECTING_IP' => __( 'Use the Cloudflare "CF-Connecting-IP" HTTP header to get a visitor IP. Only use if you\'re using Cloudflare.', 'url-shortify' ),
		),

		'default' => '',
		'order'   => 3
	);

	$reporting_options = apply_filters( 'kc_us_filter_default_reports_options', $default_reporting_options );

	$order = array_column( $reporting_options, 'order' );

	array_multisort( $order, SORT_ASC, $reporting_options );

	$sections = array(
		array(
			'tab_id'        => 'general',
			'section_id'    => 'settings',
			'section_title' => __( 'Settings', 'url-shortify' ),
			'section_order' => 10,
			'fields'        => $general_options
		),

		array(
			'tab_id'        => 'links',
			'section_id'    => 'default_link_options',
			'section_title' => __( 'Default Link Options' ),
			'section_order' => 8,
			'fields'        => $default_link_options
		),

		array(
			'tab_id'        => 'reports',
			'section_id'    => 'reporting_options',
			'section_title' => __( 'Reporting Options', 'url-shortify' ),
			'section_order' => 10,
			'fields'        => $reporting_options
		)

	);

	$sections = apply_filters( 'kc_us_filter_settings_sections', $sections );

	$wpsf_settings['sections'] = $sections;

	return $wpsf_settings;
}
