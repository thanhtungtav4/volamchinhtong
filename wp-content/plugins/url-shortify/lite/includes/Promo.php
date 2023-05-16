<?php

namespace Kaizen_Coders\Url_Shortify;

/**
 * Class Promo
 *
 * Handle Promotional Campaign
 *
 * @package Kaizen_Coders\Url_Shortify
 *
 * @since 1.5.12.2
 */
class Promo {
	/**
	 * Initialize Promotions
	 *
	 * @since 1.5.12.2
	 */
	public function init() {
		add_action( 'admin_init', array( $this, 'dismiss_promotions' ) );
		add_action( 'admin_notices', array( $this, 'handle_promotions' ) );
	}

	/**
	 * Get Valid Promotions.
	 *
	 * @return string[]
	 *
	 * @since 1.5.12.2
	 */
	public function get_valid_promotions() {
		return array(
			'welcome_offer',
			'anniversary_offer',
            'jully_2022_month_end_promotion',
            'third_anniversary_promotion',
		);
	}

	/**
	 * Dismiss Promotions.
	 *
	 * @since 1.5.12.2
	 */
	public function dismiss_promotions() {
		if ( isset( $_GET['kc_us_dismiss_admin_notice'] ) && $_GET['kc_us_dismiss_admin_notice'] == '1' && isset( $_GET['option_name'] ) ) {

			$option_name = sanitize_text_field( $_GET['option_name'] );

			$valid_options = $this->get_valid_promotions();

			if ( in_array( $option_name, $valid_options ) ) {

				update_option( 'kc_us_' . $option_name . '_dismissed', 'yes', false );

				if ( in_array( $option_name, $valid_options ) ) {
					wp_safe_redirect( US()->get_landing_page_url() );
				} else {
					$referer = wp_get_referer();
					wp_safe_redirect( $referer );
				}
				exit();
			}
		}
	}
	/**
	 * Handle promotions activity.
	 *
	 * @since 1.5.12.2
	 */
	public function handle_promotions() {
		if ( ! US()->is_pro() ) {
			$third_anniversary_sale_conditions = array(
				'start_date'                    => '2023-04-19',
				'end_date'                      => '2023-04-30',
				'total_links'                   => 1,
				'start_after_installation_days' => 2,
				'promotion'                     => 'third_anniversary_promotion'
			);

			$month_end_sale_conditions = array(
				'start_date'                    => '2022-07-26',
				'end_date'                      => '2022-08-02',
				'total_links'                   => 1,
				'start_after_installation_days' => 2,
				'promotion'                     => 'jully_2022_month_end_promotion'
			);

			$welcome_offer_conditions = array(
				'total_links'                   => 3,
				'start_after_installation_days' => 10,
				'end_before_installation_days' => 14,
				'promotion'                     => 'welcome_offer'
			);

            // Month end promotion.
			if (Helper::can_show_promotion($third_anniversary_sale_conditions)) {
				$this->show_promotion('third_anniversary_promotion');
			} else if (Helper::can_show_promotion($welcome_offer_conditions)) {
				$this->show_promotion('welcome_offer');
			} else {
				$this->show_promotion('regular_upgrade_banner');
			}
		}
	}

	/**
	 * Show Promotion.
	 *
	 * @param $promotion
	 *
	 * @since 1.5.12.2
	 */
	public function show_promotion( $promotion ) {

		$current_screen_id = Helper::get_current_screen_id();

		if ( 'regular_upgrade_banner' === $promotion && Helper::is_plugin_admin_screen( $current_screen_id ) ) {
			$action = Helper::get_data( $_GET, 'action' );
			if ( 'statistics' === $action ) {
				?>
                <div class="wrap">
					<?php Helper::get_upgrade_banner(); ?>
                </div>
				<?php
			}
		} else {

			$query_strings = array(
				'kc_us_dismiss_admin_notice' => 1,
				'option_name'                => $promotion
			);

			?>

            <div class="wrap">
				<?php Helper::get_upgrade_banner( $query_strings, true ); ?>
            </div>
			<?php
		}
	}

	/**
	 * Is Promo displayed and dismissed by user?
	 *
	 * @param $promo
	 *
	 * @return bool
	 *
	 * @since 1.5.12.2
	 */
	public function is_promotion_dismissed($promotion) {
		if(empty($promotion)) {
			return false;
		}

		$promotion_dismissed_option = 'kc_us_' . trim($promotion) . '_dismissed';

		return 'yes' === get_option($promotion_dismissed_option);
	}
}
