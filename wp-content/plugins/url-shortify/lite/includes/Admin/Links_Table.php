<?php

namespace Kaizen_Coders\Url_Shortify\Admin;

use Kaizen_Coders\Url_Shortify\Admin\Controllers\LinkStatsController;
use Kaizen_Coders\Url_Shortify\Admin\DB\Links;
use Kaizen_Coders\Url_Shortify\Cache;
use Kaizen_Coders\Url_Shortify\Common\Utils;
use Kaizen_Coders\Url_Shortify\Helper;

/**
 * Class Links_Table
 *
 * @since 1.0.0
 * @package Kaizen_Coders\Url_Shortify\Admin
 *
 */
class Links_Table extends US_List_Table {
	/**
	 * @since 1.0.0
	 * @var string
	 *
	 */
	public static $option_per_page = 'us_links_per_page';

	/**
	 * @var Links
	 */
	public $db;

	/**
	 * Group ID Name Map
	 *
	 * @since 1.3.7
	 */
	public $group_id_name_map;

	/**
	 * Links_Table constructor.
	 */
	public function __construct() {

		parent::__construct( array(
			'singular' => __( 'Link', 'url-shortify' ), //singular name of the listed records
			'plural'   => __( 'Links', 'url-shortify' ), //plural name of the listed records
			'ajax'     => false, //does this table support ajax?
			'screen'   => 'us_links'
		) );

		$this->db = new Links();

		$this->group_id_name_map = US()->db->groups->get_id_name_map();

		$link_id = Helper::get_request_data( 'id', null );

		if ( ! is_null( $link_id ) ) {
			if ( US()->access->can( 'create_links' ) && ! US()->access->can( 'manage_links' ) ) {
				$link            = $this->db->get_by_id( $link_id );
				$created_by_id   = Helper::get_data( $link, 'created_by_id', 0 );
				$current_user_id = get_current_user_id();
				if ( $created_by_id != $current_user_id ) {
					die( 'You do not have permission to access this page' );
				}

			}
		}

	}

	/**
	 * Add Screen Option
	 *
	 * @since 1.0.0
	 */
	public static function screen_options() {

		$action = Helper::get_request_data( 'action' );

		$restricted_actions = array( 'new', 'edit', 'statistics' );

		if ( ! in_array( $action, $restricted_actions ) ) {

			$option = 'per_page';
			$args   = array(
				'label'   => __( 'Number of Links per page', 'url-shortify' ),
				'default' => 10,
				'option'  => self::$option_per_page
			);

			add_screen_option( $option, $args );
		}

	}

	/**
	 * Render links page
	 *
	 * @since 1.0.0
	 */
	public function render() {

		try {

			$action = Helper::get_request_data( 'action' );

			if ( 'new' === $action || 'edit' === $action ) {

				$link_id = Helper::get_request_data( 'id', null );

				$this->render_form( $link_id );

			} elseif ( 'statistics' === $this->current_action() ) {
				// In our file that handles the request, verify the nonce.
				$nonce = Helper::get_request_data( '_wpnonce' );

				if ( ! wp_verify_nonce( $nonce, 'us_action_nonce' ) ) {
					$message = __( 'You do not have permission to view statistics of this link.', 'url-shortify' );
					US()->notices->error( $message );
				} else {

					$link_id = Helper::get_request_data( 'id' );

					if ( ! empty( $link_id ) ) {
						$link = new LinkStatsController( $link_id );
						$link->render();
					}
				}
			} else {

				$template_data = array(
					'object'       => $this,
					'title'        => __( 'Links', 'url-shortify' ),
					'add_new_link' => add_query_arg( 'action', 'new', admin_url( 'admin.php?page=us_links' ) )
				);

				ob_start();

				include KC_US_ADMIN_TEMPLATES_DIR . '/links.php';
			}


		} catch ( \Exception $e ) {

		}

	}

	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {

		$columns = array(
			'cb'          => '<input type="checkbox" />',
			'title'       => __( 'Title', 'url-shortify' ),
			'clicks'      => __( 'Clicks', 'url-shortify' ),
			'redirect'    => __( 'Redirect Type', 'url-shortify' ),
			'groups'      => __( 'Groups', 'url-shortify' ),
			'linked_post' => __( 'Linked Post', 'url-shortify' ),
			'created_at'  => __( 'Created On', 'url-shortify' ),
			'link'        => __( 'Link', 'url-shortify' ),
		);

		return apply_filters( 'kc_us_filter_links_columns', $columns );

	}

	function prepare_groups_dropdown() {
		$data = '<label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label><select name="group_id" id="group_id" class="group_select" style="display: none;">';
		$data .= Helper::prepare_group_dropdown_options();
		$data .= '</select>';

		echo wp_kses( $data, Helper::allowed_html_tags_in_esc() );
	}


	/**
	 * @param object $item
	 * @param string $column_name
	 *
	 * @return string|void
	 *
	 * @since 1.0.0
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'created_at':
				return Helper::format_date_time( $item[ $column_name ] );
				break;
			default:
				return '';
		}
	}

	/**
	 * @param $item
	 *
	 * @return string
	 *
	 * @since 1.3.1
	 */
	public function column_share( $item ) {

		$link_id = Helper::get_data( $item, 'id', 0 );

		return Helper::get_social_share_widget( $link_id );
	}

	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	function column_title( $item ) {

		$link_id = $item['id'];
		$url     = $item['url'];
		$name    = stripslashes( $item['name'] );
		$slug    = $item['slug'];

		$short_link = Helper::get_short_link( $slug, $item );

		$title = sprintf( '<span class="flex w-full"><img class="h-6 w-6 mr-2" style="min-width: 1.5rem;" src="https://www.google.com/s2/favicons?domain=%s" title="%s"/><strong>%s</strong></span>', $url, $url, $name );

		$actions = array(
			'edit'   => sprintf( __( '<a href="%s" class="text-indigo-600">Edit</a>', 'url-shortify' ), Helper::get_link_action_url( $link_id, 'edit' ) ),
			'stats'  => sprintf( __( '<a href="%s">Statistics</a>', 'url-shortify' ), Helper::get_link_action_url( $link_id, 'statistics' ) ),
			'delete' => sprintf( __( '<a href="%s" onclick="return confirmDelete();" >Delete</a>', 'url-shortify' ), Helper::get_link_action_url( $link_id, 'delete' ) ),
			'reset'  => sprintf( __( '<a href="%s" onclick="return confirmReset();" >Reset Stats</a>', 'url-shortify' ), Helper::get_link_action_url( $link_id, 'reset' ) ),
			'link'   => sprintf( __( '<a href="%s" target="_blank" title="Visit Link"><i class="fa fa-external-link-square"></i></a>', 'url-shortify' ), $short_link ),
		);

		$actions = apply_filters( 'kc_us_filter_links_actions', $actions, $item );

		return $title . $this->row_actions( $actions, false, 'ml-8' );
	}

	/**
	 * Render link column
	 *
	 * @param $item
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	function column_link( $item ) {

		$slug = Helper::get_data( $item, 'slug', '' );

		if ( empty( $slug ) ) {
			return '';
		}

		$id = Helper::get_data( $item, 'id', 0 );

		$link = Helper::get_short_link( $slug, $item );

		$input_html = '<input type="text" readonly="true" style="width: 50%;" onclick="this.select();" value="/' . $slug . '" class="kc-us-link" />';

		$html = Helper::create_copy_short_link_html( $link, $id, $input_html );

		$html .= '';

		return $html;

	}

	/**
	 * Render link column
	 *
	 * @param $item
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	function column_clicks( $item ) {

		$link_id = Helper::get_data( $item, 'id', 0 );

		$track_me = Helper::get_data( $item, 'track_me', 0 );

		// Get data only if tracking is enabled
		if ( $track_me ) {
			$stats_url = Helper::create_link_stats_url( $link_id );

			return Helper::prepare_clicks_column( $link_id, $stats_url );
		} else {
			return '0 / 0';
		}
	}

	/**
	 * @param $item
	 *
	 * @return string
	 *
	 * @since 1.2.5
	 */
	function column_linked_post( $item ) {
		$cpt_id   = $item['cpt_id'];
		$id       = $item['id'];
		$cpt_type = $item['cpt_type'];

		if ( empty( $cpt_id ) ) {
			return '-';
		}

		if ( empty( $cpt_type ) ) {

			$cpt_type = Helper::get_cpt_type_from_cpt_id( $cpt_id );

			if ( ! empty( $cpt_type ) ) {

				$data = array(
					'cpt_type' => $cpt_type
				);

				$this->db->update( $id, $data );
			}

		}

		$cpt_info = Helper::get_cpt_info( $cpt_type );

		$title = $cpt_info['title'];
		$icon  = $cpt_info['icon'];

		$permalink = get_permalink( $cpt_id );

		return "<a href='{$permalink}' title='{$title}' target='_blank'><img src='{$icon}' alt='{$title}' /></a>";
	}

	/**
	 * Get the redirect type
	 *
	 * @param $item
	 *
	 * @return array|\Kaizen_Coders\Url_Shortify\data|string
	 *
	 * @since 1.3.7
	 */
	function column_redirect( $item ) {

		$type = Helper::get_data( $item, 'redirect_type', '' );

		$redirect_types = Helper::get_redirection_types();

		return Helper::get_data( $redirect_types, $type, '' );
	}

	function column_groups( $item ) {

		$link_id = Helper::get_data( $item, 'id', '' );

		if ( empty( $link_id ) ) {
			return '';
		}

		$group_ids = US()->db->links_groups->get_group_ids_by_link_id( $link_id );

		return Helper::get_group_str_from_ids( $group_ids, $this->group_id_name_map );
	}

	/**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="link_ids[]" value="%s"/>', $item['id']
		);
	}

	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		return array(
			'title'      => array( 'name', true ),
			'created_at' => array( 'created_at', true )
		);

	}

	/**
	 * @param int $per_page
	 * @param int $page_number
	 * @param bool $do_count_only
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function get_lists( $per_page = 10, $page_number = 1, $do_count_only = false ) {
		global $wpdb;

		$order_by           = sanitize_sql_orderby( Helper::get_request_data( 'orderby' ) );
		$order              = Helper::get_request_data( 'order' );
		$search             = Helper::get_request_data( 's' );
		$filter_by_group_id = Helper::get_request_data( 'filter_by_group', '' );

		$table = $this->db->table_name;

		if ( $do_count_only ) {
			$sql = "SELECT count(*) as total FROM {$table}";
		} else {
			$sql = "SELECT * FROM {$table}";
		}

		$args = $query = array();

		$add_where_clause = false;

		if ( ! empty( $search ) ) {
			$query[] = ' name LIKE %s OR slug LIKE %s OR url LIKE %s OR description LIKE %s';
			$args[]  = '%' . $wpdb->esc_like( $search ) . '%';
			$args[]  = '%' . $wpdb->esc_like( $search ) . '%';
			$args[]  = '%' . $wpdb->esc_like( $search ) . '%';
			$args[]  = '%' . $wpdb->esc_like( $search ) . '%';

			$add_where_clause = true;
		}

		if ( ! US()->access->can( 'manage_links' ) && US()->access->can( 'create_links' ) ) {
			$query[] = ' created_by_id = %d ';
			$args[]  = get_current_user_id();

			$add_where_clause = true;
		}

        // Filter links by group.
		if ( ! empty( $filter_by_group_id ) ) {
			$add_where_clause = true;

            $links_group_table = US()->db->links_groups->table_name;
			$filter_sql = $wpdb->prepare( "SELECT link_id FROM {$links_group_table} WHERE group_id = %d", $filter_by_group_id );

			$query[] = "id IN ( $filter_sql )";
		}

		if ( $add_where_clause ) {
			$sql .= ' WHERE ';

			if ( count( $query ) > 0 ) {
				$sql .= implode( ' AND ', $query );
				if ( count( $args ) > 0 ) {
					$sql = $wpdb->prepare( $sql, $args );
				}
			}
		}

		if ( ! $do_count_only ) {

			$order = ! empty( $order ) ? strtolower( $order ) : 'desc';

			$expected_order_values = array( 'asc', 'desc' );

			if ( ! in_array( $order, $expected_order_values ) ) {
				$order = 'desc';
			}

			$default_order_by = esc_sql( 'created_at' );

			$expected_order_by_values = array( 'name', 'created_at' );

			if ( ! in_array( $order_by, $expected_order_by_values ) ) {
				$order_by_clause = " ORDER BY {$default_order_by} DESC";
			} else {
				$order_by        = esc_sql( $order_by );
				$order_by_clause = " ORDER BY {$order_by} {$order}, {$default_order_by} DESC";
			}

			$sql .= $order_by_clause;
			$sql .= " LIMIT $per_page";
			$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;

			$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		} else {
			$result = $wpdb->get_var( $sql );
		}

		return $result;
	}

	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function get_bulk_actions() {

		$bulk_action = array(
			'bulk_delete'     => __( 'Delete', 'url-shortify' ),
			'bulk_group_add'  => __( 'Add to group', 'url-shortify' ),
			'bulk_group_move' => __( 'Move to group', 'url-shortify' ),
		);

		return apply_filters( 'kc_us_link_bulk_actions', $bulk_action );
	}

	/**
	 * Process bulk action
	 *
	 * @since 1.0.0
	 */
	public function process_bulk_action() {

		$action  = Helper::get_request_data( 'action' );
		$action2 = Helper::get_request_data( 'action2' );

		if ( 'delete' === $this->current_action() ) {

			// In our file that handles the request, verify the nonce.
			$nonce = Helper::get_request_data( '_wpnonce' );

			if ( ! wp_verify_nonce( $nonce, 'us_action_nonce' ) ) {
				$message = __( 'You do not have permission to delete this link.', 'url-shortify' );
				US()->notices->error( $message );
			} else {

				$link_id = Helper::get_request_data( 'id' );

				if ( ! empty( $link_id ) ) {
					$this->db->delete( $link_id );

					$message = __( 'Link has been deleted successfully!', 'url-shortify' );
					US()->notices->success( $message );
				}
			}
		} elseif ( 'reset' === $this->current_action() ) {

			// In our file that handles the request, verify the nonce.
			$nonce = Helper::get_request_data( '_wpnonce' );

			if ( ! wp_verify_nonce( $nonce, 'us_action_nonce' ) ) {
				$message = __( 'You do not have permission to reset statistics of this link.', 'url-shortify' );
				US()->notices->error( $message );
			} else {

				$link_id = Helper::get_request_data( 'id' );

				if ( ! empty( $link_id ) ) {
					$this->db->reset_stats( $link_id );

					$message = __( 'Link stats has been reset successfully!', 'url-shortify' );
					US()->notices->success( $message );
				}
			}
		} elseif ( ( 'bulk_delete' === $action ) || ( 'bulk_delete' === $action2 ) ) {

			// In our file that handles the request, verify the nonce.
			$nonce  = Helper::get_request_data( '_wpnonce' );
			$action = 'bulk-' . Helper::get_data( $this->_args, 'plural', '' );

			if ( ! wp_verify_nonce( $nonce, $action ) ) {
				$message = __( 'You do not have permission to delete link(s).', 'url-shortify' );
				US()->notices->error( $message );
			} else {

				$link_ids = Helper::get_request_data( 'link_ids' );

				if ( ! empty( $link_ids ) ) {
					$this->db->delete( $link_ids );
					$message = __( 'Link(s) have been deleted successfully!', 'url-shortify' );
					US()->notices->success( $message );
				} else {
					$message = __( 'Please select link(s) to delete.', 'url-shortify' );
					US()->notices->error( $message );

					return;
				}
			}

		} elseif ( ( 'bulk_reset' === $action ) || ( 'bulk_reset' === $action2 ) ) {

			// In our file that handles the request, verify the nonce.
			$nonce  = Helper::get_request_data( '_wpnonce' );
			$action = 'bulk-' . Helper::get_data( $this->_args, 'plural', '' );

			if ( ! wp_verify_nonce( $nonce, $action ) ) {
				$message = __( 'You do not have permission to reset stats.', 'url-shortify' );
				US()->notices->error( $message );
			} else {

				$link_ids = Helper::get_request_data( 'link_ids' );

				if ( ! empty( $link_ids ) ) {

					do_action( 'kc_us_bulk_reset_link_stats', $link_ids );

					$message = __( 'Link(s) stats have been reset successfully!', 'url-shortify' );
					US()->notices->success( $message );
				} else {
					$message = __( 'Please select link(s) to reset stats.', 'url-shortify' );
					US()->notices->error( $message );

					return;
				}
			}
		} elseif ( ( 'bulk_group_add' === $action ) || ( 'bulk_group_add' === $action2 ) ) {

			// In our file that handles the request, verify the nonce.
			$nonce  = Helper::get_request_data( '_wpnonce' );
			$action = 'bulk-' . Helper::get_data( $this->_args, 'plural', '' );

			if ( ! wp_verify_nonce( $nonce, $action ) ) {
				$message = __( 'You do not have permission to add links to group.', 'url-shortify' );
				US()->notices->error( $message );
			} else {

				$link_ids = Helper::get_request_data( 'link_ids' );

				$group_id = Helper::get_request_data( 'group_id' );;

				if ( empty( $link_ids ) ) {
					$message = __( 'Please select link(s) to add into group.', 'url-shortify' );
					US()->notices->error( $message );

					return;
				}

				if ( empty( $group_id ) ) {
					$message = __( 'Please select group to add links to.', 'url-shortify' );
					US()->notices->error( $message );

					return;
				}

				US()->db->links_groups->map_links_and_groups( $link_ids, $group_id );

				$message = __( 'Link(s) have been added to group successfully!', 'url-shortify' );

				US()->notices->success( $message );
			}
		} elseif ( ( 'bulk_group_move' === $action ) || ( 'bulk_group_move' === $action2 ) ) {
			// In our file that handles the request, verify the nonce.
			$nonce  = Helper::get_request_data( '_wpnonce' );
			$action = 'bulk-' . Helper::get_data( $this->_args, 'plural', '' );

			if ( ! wp_verify_nonce( $nonce, $action ) ) {
				$message = __( 'You do not have permission to move links to group.', 'url-shortify' );
				US()->notices->error( $message );
			} else {

				$link_ids = Helper::get_request_data( 'link_ids' );

				$group_id = Helper::get_request_data( 'group_id' );;

				if ( empty( $link_ids ) ) {
					$message = __( 'Please select link(s) to move into group.', 'url-shortify' );
					US()->notices->error( $message );

					return;
				}

				if ( empty( $group_id ) ) {
					$message = __( 'Please select group to move links to.', 'url-shortify' );
					US()->notices->error( $message );

					return;
				}

				US()->db->links_groups->map_links_and_groups( $link_ids, $group_id, true );

				$message = __( 'Link(s) have been moved to group successfully!', 'url-shortify' );

				US()->notices->success( $message );
			}
		}
	}

	/**
	 * @param $link_id
	 *
	 * @since 1.0.0
	 */
	public function render_form( $link_id = null ) {

		$is_new = true;
		if ( ! empty( $link_id ) ) {
			$is_new = false;
		}

		$submitted = Helper::get_request_data( 'submitted' );

		$form_data = $this->get_form_data( $link_id );

		if ( 'submitted' === $submitted ) {

			$nonce = Helper::get_request_data( '_wpnonce' );

			$form_data = Helper::get_request_data( 'form_data', array(), false );

			$form_data['nonce'] = $nonce;

			$response = $this->validate_data( $form_data );

			if ( 'error' === $response['status'] ) {
				$message = $response['message'];
				US()->notices->error( $message );
			} else {

				$save = $this->save( $form_data, $link_id );

				if ( $save ) {

					$value = array(
						'status'  => 'success',
						'message' => __( 'Link data have been saved successfully!', 'url-shortify' )
					);

					Cache::set_transient( 'notice', $value );
				}

				$url = admin_url( 'admin.php?page=us_links' );
				wp_redirect( $url );
				exit();
			}

		}

		$nonce = wp_create_nonce( 'us_link_form' );

		try {

			if ( $link_id ) {
				$title       = __( 'Edit Link', 'url-shortify' );
				$button_text = __( 'Save Changes', 'url-shortify' );

				$query_args = array(
					'action'   => 'edit',
					'id'       => $link_id,
					'_wpnonce' => $nonce
				);


			} else {
				$title       = __( 'New Link', 'url-shortify' );
				$button_text = __( 'Save Link', 'url-shortify' );

				$query_args = array(
					'action'   => 'new',
					'_wpnonce' => $nonce
				);

			}

			$form_action = add_query_arg( $query_args, admin_url( 'admin.php?page=us_links' ) );

			$template_data = array(
				'title'             => $title,
				'link_id'           => $link_id,
				'button_text'       => $button_text,
				'form_action'       => $form_action,
				'form_data'         => $form_data,
				'blog_url'          => $is_new ? trailingslashit( Helper::get_blog_url( true ) ) : trailingslashit( Helper::get_blog_url() ),
				'redirection_types' => Helper::get_redirection_types(),
				'domains'           => Helper::get_domains(),
				'groups'            => US()->db->groups->get_id_name_map()
			);

			include_once KC_US_ADMIN_TEMPLATES_DIR . '/link-form.php';

		} catch ( \Exception $e ) {

		}


	}

	/**
	 * Get Form data
	 *
	 * @param int $link_id
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function get_form_data( $link_id = 0 ) {

		$results = array();

		if ( ! empty( $link_id ) ) {
			$results = $this->db->get( $link_id );
		}

		$default_settings = US()->get_settings();

		$default_redirection_type    = Helper::get_data( $default_settings, 'links_default_link_options_redirection_type', 307 );
		$default_nofollow            = Helper::get_data( $default_settings, 'links_default_link_options_enable_nofollow', 1 );
		$default_sponsored           = Helper::get_data( $default_settings, 'links_default_link_options_enable_sponsored', 0 );
		$default_paramter_forwarding = Helper::get_data( $default_settings, 'links_default_link_options_enable_paramter_forwarding', 0 );
		$default_track_me            = Helper::get_data( $default_settings, 'links_default_link_options_enable_tracking', 1 );
		$default_domain              = Helper::get_data( $default_settings, 'links_default_link_options_default_custom_domain', '' );

		return array(
			'name'              => Helper::get_data( $results, 'name', '' ),
			'url'               => Helper::get_data( $results, 'url', '' ),
			'slug'              => Helper::get_data( $results, 'slug', Utils::get_valid_slug() ),
			'redirect_type'     => Helper::get_data( $results, 'redirect_type', $default_redirection_type ),
			'description'       => Helper::get_data( $results, 'description', '' ),
			'nofollow'          => Helper::get_data( $results, 'nofollow', $default_nofollow ),
			'sponsored'         => Helper::get_data( $results, 'sponsored', $default_sponsored ),
			'params_forwarding' => Helper::get_data( $results, 'params_forwarding', $default_paramter_forwarding ),
			'track_me'          => Helper::get_data( $results, 'track_me', $default_track_me ),
			'cpt_id'            => Helper::get_data( $results, 'cpt_id', '' ),
			'cpt_type'          => Helper::get_data( $results, 'cpt_type', '' ),
			'group_ids'         => Helper::get_data( $results, 'group_ids', array() ),
			'expires_at'        => Helper::get_data( $results, 'expires_at', '' ),
			'password'          => Helper::get_data( $results, 'password', '' ),
			'rules'             => maybe_unserialize( Helper::get_data( $results, 'rules', '' ) ),
			'default_domain'    => $default_domain,
		);

	}

	/**
	 * Validate data
	 *
	 * @param array $data
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function validate_data( $data = array() ) {

		$status   = 'success';
		$error    = false;
		$messages = array();

		$nonce = Helper::get_data( $data, 'nonce', '' );
		if ( ! wp_verify_nonce( $nonce, 'us_link_form' ) ) {
			$messages[] = __( 'You do not have permission to edit this form.', 'url-shortify' );
			$error      = true;
		} else {
			$title      = Helper::get_data( $data, 'name', '' );
			$target_url = Helper::get_data( $data, 'url', '' );

			if ( empty( $title ) ) {
				$messages[] = __( 'Please enter Title', 'url-shortify' );
				$error      = true;
			}

			if ( empty( $target_url ) ) {
				$messages[] = __( 'Please enter Target URL', 'url-shortify' );
				$error      = true;
			} elseif ( ! preg_match( "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $target_url ) ) {
				$messages[] = __( 'Please enter valid Target URL', 'url-shortify' );
				$error      = true;
			}

		}

		$message = '';
		if ( $error ) {
			$message = implode( ', ', $messages );
			$status  = 'error';
		}

		return array(
			'status'  => $status,
			'message' => $message
		);
	}

	/**
	 * Insert/ Update form data
	 *
	 * @param array $data
	 * @param null $id
	 *
	 * @return bool|int
	 *
	 * @since 1.0.0
	 */
	public function save( $data = array(), $id = null ) {

		$form_data = $this->db->prepare_form_data( $data, $id );

		$link_id = $this->db->save( $form_data, $id );

		if ( $id ) {
			$link_id = $id;
		}

		$group_ids = Helper::get_data( $data, 'group_ids', array() );

		// Add link to groups
		return US()->db->links_groups->add_link_to_groups( $link_id, $group_ids );
	}

	public function search_box( $text, $input_id ) {
		?>

        <p class="search-box">
            <label class="screen-reader-text"
                   for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $text ); ?>:</label>
            <input type="search" class="kc-us-links-search" id="<?php echo esc_attr( $input_id ); ?>" name="s"
                   value="<?php _admin_search_query(); ?>"/>
			<?php submit_button( __( 'Search Links', 'url-shortify' ), 'button', false, false, array( 'id' => 'search-submit' ) ); ?>
        </p>

        <p class="search-box-group">
			<?php $group_id = Helper::get_request_data( 'filter_by_group', '' ); ?>
            <select name="filter_by_group">
				<?php
				$allowed_tags = Helper::allowed_html_tags_in_esc();
				$groups       = Helper::prepare_group_dropdown_options( $group_id, __( 'All Groups', 'url-shortify' ) );
				echo wp_kses( $groups, $allowed_tags );
				?>
            </select>
        </p>
		<?php
	}

	/**
	 * No items
	 *
	 * @since 1.0.0
	 */
	public function no_items() { ?>

        <div class="block ml-auto mr-auto" style="width:50%;">
            <img src="<?php echo KC_US_PLUGIN_ASSETS_DIR_URL . '/images/empty.svg' ?>"/>
        </div>


	<?php }
}
