<?php

namespace Kaizen_Coders\Url_Shortify\Admin\Controllers;

use Kaizen_Coders\Url_Shortify\Admin\DB\Links;
use Kaizen_Coders\Url_Shortify\Common\Utils;
use Kaizen_Coders\Url_Shortify\Helper;

class LinksController extends BaseController {

	/**
	 * @var Links|null
	 *
	 * @since 1.1.5
	 */
	public $db = null;

	/**
	 * LinksController constructor.
	 *
	 * @since 1.1.3
	 */
	public function __construct() {

		$this->db = new Links();

		parent::__construct();
	}

	/**
	 * Create Short Link
	 *
	 * @param array $data
	 *
	 * @return array|string[]
	 *
	 * @since 1.1.3
	 */
	public function create( $data = array() ) {

		$post_id = Helper::get_data( $data, 'post_id', 0 );

		$url = $title = '';
		if ( ! empty( $post_id ) ) {
			$link_id = $this->create_link_from_post( $post_id );
			$slug    = Utils::get_valid_slug();
		} else {
			$url    = Helper::get_data( $data, 'url', '' );
			$domain = Helper::get_data( $data, 'domain', 'home' );
			$title  = Utils::get_title_from_url( $url );

			$link_data = array(
				'url'  => $url,
				'name' => $title
			);

			$link_data['rules']['domain'] = $domain;

			$slug = Helper::get_data( $data, 'slug', '' );

			if ( empty( $slug ) ) {
				$slug = Utils::get_valid_slug();
			}

			$slug = Helper::get_slug_with_prefix( $slug );

			$link_id = $this->create_link_from_data( $link_data, $slug );
		}

		if ( $link_id ) {

			$link = Helper::get_short_link( $slug, $link_data );

			$response = array(
				'status'     => 'success',
				'link'       => $link,
				'target_url' => $url,
				'title'      => $title,
				'html'       => Helper::create_copy_short_link_html( $link, $post_id )
			);

		} else {
			$response = array(
				'status' => 'error'
			);
		}

		return $response;

	}

	/**
	 * Get Short Link by CPT id
	 *
	 * @param int $cpt_id
	 *
	 * @return bool|string
	 *
	 * @since 1.1.5
	 */
	public function get_short_link_by_cpt_id( $cpt_id = 0 ) {

		$link = $this->db->get_by_cpt_id( $cpt_id );

		if ( ! empty( $link ) ) {
			return Helper::get_short_link( $link['slug'] );
		}

		return false;
	}

	/**
	 * Generate link from post
	 *
	 * @param string $post
	 * @param string $slug
	 *
	 * @return boolean
	 *
	 * @since 1.2.5
	 */
	public function create_link_from_post( $post = '', $slug = '' ) {

		$post = get_post( $post );

		if ( $post instanceof \WP_Post ) {

			$link_data = array(
				'cpt_id'      => $post->ID,
				'url'         => get_permalink( $post->ID ),
				'name'        => addslashes( $post->post_title ),
				'description' => addslashes( $post->post_excerpt )
			);

			return $this->db->create_link( $link_data, $slug );
		}

		return false;
	}

	/**
	 * @param array $link_data
	 * @param string $slug
	 *
	 * @return bool|int
	 *
	 * @since 1.2.5
	 */
	public function create_link_from_data( $link_data = array(), $slug = '' ) {
		return $this->db->create_link( $link_data, $slug );
	}
}
