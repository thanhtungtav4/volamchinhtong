<?php

namespace Kaizen_Coders\Url_Shortify\Admin\DB;

use Kaizen_Coders\Url_Shortify\Common\Utils;
use Kaizen_Coders\Url_Shortify\Helper;

class Links extends Base_DB {
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
	 * constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		global $wpdb;

		parent::__construct();

		$this->table_name = $wpdb->prefix . 'kc_us_links';

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
			'id'                => '%d',
			'name'              => '%s',
			'slug'              => '%s',
			'url'               => '%s',
			'description'       => '%s',
			'nofollow'          => '%d',
			'track_me'          => '%d',
			'sponsored'         => '%d',
			'params_forwarding' => '%d',
			'params_structure'  => '%s',
			'redirect_type'     => '%s',
			'status'            => '%d',
			'type'              => '%s',
			'type_id'           => '%d',
			'password'          => '%s',
			'expires_at'        => '%s',
			'cpt_id'            => '%d',
			'cpt_type'          => '%s',
			'rules'             => '%s',
			'created_at'        => '%s',
			'created_by_id'     => '%d',
			'updated_at'        => '%s',
			'updated_by_id'     => '%d',
		);
	}

	/**
	 * Get default column values
	 *
	 * @since 1.0.0
	 */
	public function get_column_defaults() {

		return array(
			'name'              => '',
			'slug'              => '',
			'description'       => '',
			'url'               => null,
			'nofollow'          => 0,
			'track_me'          => 1,
			'sponsored'         => 0,
			'params_forwarding' => 0,
			'params_structure'  => null,
			'redirect_type'     => 307,
			'status'            => 1,
			'type'              => 'direct',
			'type_id'           => null,
			'password'          => null,
			'expires_at'        => null,
			'cpt_id'            => null,
			'cpt_type'          => null,
			'rules'             => null,
			'created_at'        => Helper::get_current_date_time(),
			'created_by_id'     => null,
			'updated_at'        => null,
			'updated_by_id'     => null,
		);
	}

	/**
	 * Get link data based on link_id
	 *
	 * @param null $link_id
	 * @param string $output
	 *
	 * @return array|object|void|null
	 *
	 * @since 1.1.3
	 */
	public function get( $link_id = null, $output = ARRAY_A ) {

		if ( empty( $link_id ) ) {
			return array();
		}

		$link_data = parent::get( $link_id, $output );

		$groups = US()->db->links_groups->get_group_ids_by_link_ids( $link_id );

		$group_ids = Helper::get_data( $groups, $link_id, array() );

		$link_data['group_ids'] = $group_ids;

		return $link_data;
	}

	/**
	 * Get link by slug
	 *
	 * @param null $slug
	 *
	 * @return array|object|void|null
	 *
	 * @since 1.0.0
	 */
	public function get_by_slug( $slug = null ) {

		if ( empty( $slug ) ) {
			return array();
		}

		return $this->get_by( 'slug', $slug );
	}

	/**
	 * Get link by id
	 *
	 * @param int $id
	 *
	 * @return array|object|void|null
	 *
	 * @since 1.0.0
	 */
	public function get_by_id( $id = 0 ) {

		if ( empty( $id ) ) {
			return array();
		}

		return $this->get_by( 'id', $id );
	}

	/**
	 * Get links by IDs
	 *
	 * @param array $ids
	 *
	 * @return array|object|void|null
	 *
	 * @since 1.1.7
	 */
	public function get_by_ids( $ids = array() ) {

		if ( empty( $ids ) ) {
			return array();
		}

		if ( is_scalar( $ids ) ) {
			$ids = array( $ids );
		}

		if ( ! is_array( $ids ) ) {
			return array();
		}

		$ids_str = $this->prepare_for_in_query( $ids );
		$where   = "id IN ($ids_str)";

		return $this->get_by_conditions( $where );
	}

	/**
	 * Get link by cpt_id
	 *
	 * @param int $cpt_id
	 *
	 * @return array|object|void|null
	 *
	 * @since 1.1.0
	 */
	public function get_by_cpt_id( $cpt_id = 0 ) {

		if ( empty( $cpt_id ) ) {
			return array();
		}

		return $this->get_by( 'cpt_id', $cpt_id );
	}

	/**
	 * Get my link ids.
	 *
	 * @param int $created_by_id
	 *
	 * @return array|object|void|null
	 *
	 * @since 1.6.1
	 */
	public function get_my_link_ids( $created_by_id = 0 ) {
		if ( empty( $created_by_id ) ) {
			return array();
		}

		return $this->get_column_by( 'id', 'created_by_id', $created_by_id );
	}

	/**
	 * Delete Links
	 *
	 * @param $ids array
	 *
	 * @since 1.0.0
	 */
	public function delete( $ids = array() ) {

		if ( ! is_array( $ids ) ) {
			$ids = array( $ids );
		}

		if ( is_array( $ids ) && count( $ids ) > 0 ) {

			foreach ( $ids as $id ) {
				parent::delete( absint( $id ) );

				/**
				 * Take necessary cleanup steps using this hook
				 *
				 * @since 1.0.0
				 */
				do_action( 'kc_us_link_deleted', $id );
			}
		}

		// Clean up on link deletion
		do_action( 'kc_us_links_deleted' );
	}

	/**
	 * Reset links statistics
	 *
	 * @param array $ids
	 *
	 * @since 1.4.10
	 */
	public function reset_stats( $ids = array() ) {

		if ( ! is_array( $ids ) ) {
			$ids = array( $ids );
		}

		if ( is_array( $ids ) && count( $ids ) > 0 ) {

			foreach ( $ids as $id ) {
				US()->db->clicks->delete_by_link_id( $id );

				/**
				 * Take necessary cleanup steps using this hook
				 *
				 * @since 1.4.10
				 */
				do_action( 'kc_us_link_stats_reset', $id );
			}
		}
	}

	/**
	 * Prepare formdata
	 *
	 * @param array $data
	 * @param null $id
	 *
	 * @return array
	 *
	 * @since 1.1.0
	 */
	public function prepare_form_data( $data = array(), $id = null ) {

		$default_redirection_type = $default_nofollow = $default_sponsored = $default_paramter_forwarding = $default_track_me = 0;

        $slug = Helper::get_data( $data, 'slug', '', true );
		if ( is_null( $id ) ) {

            $default_settings = US()->get_settings();

            $default_redirection_type    = Helper::get_data( $default_settings, 'links_default_link_options_redirection_type', 307 );
            $default_nofollow            = Helper::get_data( $default_settings, 'links_default_link_options_enable_nofollow', 1 );
            $default_sponsored           = Helper::get_data( $default_settings, 'links_default_link_options_enable_sponsored', 0 );
            $default_paramter_forwarding = Helper::get_data( $default_settings, 'links_default_link_options_enable_paramter_forwarding', 0 );
            $default_track_me            = Helper::get_data( $default_settings, 'links_default_link_options_enable_tracking', 1 );

            $slug = Helper::get_slug_with_prefix( $slug );
		}

        $form_data = array(
            'name'              => Helper::get_data( $data, 'name', '', true ),
            'url'               => esc_url_raw( Helper::get_data( $data, 'url', '' ) ),
            'slug'              => trim( $slug, '/' ),
            'redirect_type'     => Helper::get_data( $data, 'redirect_type', $default_redirection_type, true ),
            'description'       => sanitize_textarea_field( Helper::get_data( $data, 'description', '' ) ),
            'nofollow'          => Helper::get_data( $data, 'nofollow', $default_nofollow ),
            'params_forwarding' => Helper::get_data( $data, 'params_forwarding', $default_paramter_forwarding ),
            'sponsored'         => Helper::get_data( $data, 'sponsored', $default_sponsored ),
            'track_me'          => Helper::get_data( $data, 'track_me', $default_track_me ),
            'status'            => Helper::get_data( $data, 'status', 1 ),
            'cpt_id'            => Helper::get_data( $data, 'cpt_id', null ),
            'cpt_type'          => Helper::get_data( $data, 'cpt_type', null ),
            'expires_at'        => Helper::get_data( $data, 'expires_at', null ),
            'password'          => Helper::get_data( $data, 'password', null ),
            'rules'             => maybe_serialize( Helper::get_data( $data, 'rules', array() ) )
        );

		$current_user_id   = get_current_user_id();
		$current_date_time = Helper::get_current_date_time();
		// For Updaate, we want to update updated_at & updated_by_id field
		if ( ! empty( $id ) ) {
			$form_data['updated_at']    = $current_date_time;
			$form_data['updated_by_id'] = $current_user_id;
		} else {
			// For Insert, we don't need to add updated_at & updated_by_id field
			// We just need to add created_at & created_by_id field.
			$form_data['created_at']    = $current_date_time;
			$form_data['created_by_id'] = $current_user_id;
		}

		return $form_data;
	}

	/**
	 * Default Form Data
	 *
	 * @return array
	 *
	 * @since 1.1.3
	 */
	public function default_form_data() {

		$default_settings = US()->get_settings();

		$default_redirection_type    = Helper::get_data( $default_settings, 'links_default_link_options_redirection_type', 307 );
		$default_nofollow            = Helper::get_data( $default_settings, 'links_default_link_options_enable_nofollow', 1 );
		$default_sponsored           = Helper::get_data( $default_settings, 'links_default_link_options_enable_sponsored', 0 );
		$default_paramter_forwarding = Helper::get_data( $default_settings, 'links_default_link_options_enable_paramter_forwarding', 0 );
		$default_track_me            = Helper::get_data( $default_settings, 'links_default_link_options_enable_tracking', 1 );

		return array(
			'slug'              => Utils::get_valid_slug(),
			'redirection_type'  => $default_redirection_type,
			'nofollow'          => $default_nofollow,
			'params_forwarding' => $default_paramter_forwarding,
			'sponsored'         => $default_sponsored,
			'track_me'          => $default_track_me,
		);
	}

	/**
	 * Delete clicks by cpt id
	 *
	 * @param null $cpt_id
	 *
	 * @return bool
	 *
	 * @since 1.1.0
	 */
	public function delete_by_cpt_id( $cpt_id = null ) {

		if ( empty( $cpt_id ) ) {
			return false;
		}

		return $this->delete_by( 'cpt_id', $cpt_id );
	}

	/**
	 * Create link from post
	 *
	 * @param $post
	 * @param string $slug
	 *
	 * @return bool|int
	 *
	 * @since 1.1.3
	 */
	public function create_link_from_post( $post, $slug = '' ) {

		$post = get_post( $post );

		if ( $post instanceof \WP_Post ) {

			$link_data = array(
				'cpt_id'      => $post->ID,
				'url'         => get_permalink( $post->ID ),
				'name'        => addslashes( $post->post_title ),
				'description' => addslashes( $post->post_excerpt )
			);

			if ( empty( $slug ) ) {
				$slug = Utils::get_valid_slug();
			}

			$link_data['slug'] = $slug;

			$link_data = wp_parse_args( $link_data, $this->default_form_data() );

			$link_data = $this->prepare_form_data( $link_data );

			return $this->save( $link_data );
		}

		return false;
	}

	/**
	 * Create Link
	 *
	 * @param array $link_data
	 * @param string $slug
	 *
	 * @return bool|int
	 *
	 * @since 1.2.5
	 */
	public function create_link( $link_data = array(), $slug = '' ) {

		if ( empty( $slug ) ) {
			$slug = Utils::get_valid_slug();
		}

		$link_data['slug'] = $slug;

		$link_data = wp_parse_args( $link_data, $this->default_form_data() );

		$link_data = $this->prepare_form_data( $link_data );

		return $this->save( $link_data );
	}

	/**
	 * Insert/ Update link
	 *
	 * @param array $data
	 * @param null $id
	 *
	 * @return bool|int|void
	 *
	 * @since 1.2.13
	 */
	public function save( $data = array(), $id = null ) {

		$saved = parent::save( $data, $id );

		if ( ! $saved ) {
			return false;
		}

		if ( is_null( $id ) ) {
			do_action( 'kc_us_link_created', $saved );
		} else {
			do_action( 'kc_us_link_updated', $id );
		}

		do_action( 'kc_us_link_saved' );

		return $saved;

	}


}
