<?php

use Kaizen_Coders\Url_Shortify\Admin\Controllers\ClicksController;
use Kaizen_Coders\Url_Shortify\Admin\Controllers\LinksTableController;
use Kaizen_Coders\Url_Shortify\Common\Utils;
use Kaizen_Coders\Url_Shortify\Helper;

$page_refresh_url = Utils::get_current_page_refresh_url();

$today_url        = Utils::get_stats_filter_url( array( 'time_filter' => 'today' ) );
$last_7_days_url  = Utils::get_stats_filter_url( array( 'time_filter' => 'last_7_days' ) );
$last_30_days_url = Utils::get_stats_filter_url( array( 'time_filter' => 'last_30_days' ) );
$last_60_days_url = Utils::get_stats_filter_url( array( 'time_filter' => 'last_60_days' ) );
$all_time_url     = Utils::get_stats_filter_url( array( 'time_filter' => 'all_time' ) );

$time_filter = Helper::get_data( $_GET, 'time_filter', '' );

if ( empty( $time_filter ) ) {
	$time_filter = ( US()->is_pro() ) ? 'all_time' : 'last_7_days';
}

$reports     = Helper::get_data( $data, 'reports', array() );
$clicks_data = Helper::get_data( $reports, 'clicks', array() );

$click_data_for_graph = Helper::get_data( $data, 'click_data_for_graph', array() );

$labels       = $values = '';
$total_clicks = 0;
if ( ! empty( $click_data_for_graph ) ) {
	$labels = json_encode( array_keys( $click_data_for_graph ) );

	$clicks = array_values( $click_data_for_graph );

	$total_clicks = array_sum( $clicks );

	$values = json_encode( $clicks );
}

$last_updated_on = Helper::get_data( $data, 'last_updated_on', time() );

$elapsed_time = Utils::get_elapsed_time( $last_updated_on );


$columns = array(
	'ip'         => array( 'title' => __( 'IP', 'url-shortify' ) ),
	'uri'        => array( 'title' => __( 'URI', 'url-shortify' ) ),
	'link'       => array( 'title' => __( 'Link', 'url-shortify' ) ),
	'host'       => array( 'title' => __( 'Host', 'url-shortify' ) ),
	'referrer'   => array( 'title' => __( 'Referrer', 'url-shortify' ) ),
	'clicked_on' => array( 'title' => __( 'Clicked On', 'url-shortify' ) ),
	'info'       => array( 'title' => __( 'Info', 'url-shortify' ) ),
);

$click_history = new ClicksController();
$click_history->set_columns( $columns );

$links = Helper::get_data( $data, 'links', array() );

$links_columns = array(
	'name'       => array( 'title' => __( 'Title', 'url-shortify' ) ),
	'clicks'     => array( 'title' => __( 'Clicks', 'url-shortify' ) ),
	'created_at' => array( 'title' => __( 'Created On', 'url-shortify' ) ),
	'link'       => array( 'title' => __( 'Link', 'url-shortify' ) )
);

$links_table_controller = new LinksTableController();
$links_table_controller->set_columns( $links_columns );

?>

<div class="wrap">
	<div class="font-sans bg-grey-lighter flex flex-col min-h-screen w-full">

		<div class="w-full border-b border-gray-300 pb-5">
			<div class="md:block mt-3">
				<div class="container mx-auto">
					<div class="md:flex">
						<div class="flex inline -mb-px mr-8 w-9/12">
							<span class="flex">
								<strong class="text-2xl">
									 <?php echo stripslashes( $data['name'] ); ?>
								</strong>
							</span>
						</div>

					</div>
				</div>
			</div>
		</div>

		<!-- Click History Report -->
		<div class="mt-5">
			<div class="grid grid-cols-1">
				<div class="mt-2 flex w-full border-b-2 border-gray-100">
					<div class="w-5/12">
						<span class="text-xl leading-6 font-medium text-gray-900"><?php _e( 'Clicks History', 'url-shortify' ); ?></span>
						<p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500 mb-2"><?php echo sprintf( __( '%d Total Clicks', 'url-shortify' ), $total_clicks ); ?></p>
					</div>
                    <div class="w-7/12">
                         <span class="relative z-0 inline-flex shadow-sm rounded-md float-right">
                              <button type="button" class="cursor-not-allowed relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-green-100 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 <?php if ( 'last_7_days' === $time_filter ) {
	                              echo "bg-green-100 hover:bg-green-100";
                              } ?>">
                                <a href="<?php echo $last_7_days_url; ?>" class="text-black hover:text-black"><?php _e( 'Last 7 Days', 'url-shortify' ); ?></a>
                              </button>

                             <?php if ( US()->is_pro() ) { ?>
                                  <button type="button" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-green-100 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 <?php if ( 'last_30_days' === $time_filter ) {
                                      echo "bg-green-100 hover:bg-green-100";
                                  } ?>">
                                    <a href="<?php echo $last_30_days_url; ?>" class="text-black hover:text-black"><?php _e( 'Last 30 Days', 'url-shortify' ); ?></a>
                                  </button>
                                  <button type="button" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-green-100 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 <?php if ( 'last_60_days' === $time_filter ) {
                                      echo "bg-green-100 hover:bg-green-100";
                                  } ?>">
                                    <a href="<?php echo $last_60_days_url; ?>" class="text-black hover:text-black"><?php _e( 'Last 60 Days', 'url-shortify' ); ?></a>
                                  </button>
                                  <button type="button" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-green-100 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 <?php if ( 'all_time' === $time_filter ) {
                                      echo "bg-green-100 hover:bg-green-100";
                                  } ?>">
                                    <a href="<?php echo $all_time_url; ?>" class="text-black hover:text-black"><?php _e( 'All Time', 'url-shortify' ); ?></a>
                                  </button>
                             <?php } ?>
                              <button type="button" class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-green-100 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                  <a href="<?php echo $page_refresh_url; ?>" class="text-white hover:text-white" title="Refresh">
                                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1.7em" height="1.7em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path
                                                  d="M10.2 3.28c3.53 0 6.43 2.61 6.92 6h2.08l-3.5 4l-3.5-4h2.32a4.439 4.439 0 0 0-4.32-3.45c-1.45 0-2.73.71-3.54 1.78L4.95 5.66a6.965 6.965 0 0 1 5.25-2.38zm-.4 13.44c-3.52 0-6.43-2.61-6.92-6H.8l3.5-4c1.17 1.33 2.33 2.67 3.5 4H5.48a4.439 4.439 0 0 0 4.32 3.45c1.45 0 2.73-.71 3.54-1.78l1.71 1.95a6.95 6.95 0 0 1-5.25 2.38z" fill="#626262"/></svg>
                                  </a>
                             </button>
                        </span>
                    </div>
				</div>
				<div class="bg-white mt-2" id="click-chart">

				</div>
			</div>
		</div>

		<!-- Country & Referrer Info -->
		<div class="mt-6">
			<div class="grid md:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
				<!-- Country Info -->
				<div class="overflow-hidden  rounded-lg">

					<div class="mb-4">
						<span class="text-xl leading-6 font-medium text-gray-900"><?php _e( 'Top Locations', 'url-shortify' ); ?></span>
					</div>

					<div class="bg-white border-2">
						<?php 
						if ( US()->is_pro() ) {
							do_action( 'kc_us_render_country_info', $data );
						} else { 
							?>
							<div class="w-full h-64 p-10 bg-green-50">
								<div class="">
									<div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
										<svg class="h-12 w-12 text-green-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
											<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
										</svg>
									</div>
									<div class="mt-3 text-center sm:mt-5">
										<h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
											<?php echo sprintf( __( '<a href="%s">Upgrade Now</a>', 'url-shortify' ), US()->get_landing_page_url() ); ?>
										</h3>
										<div class="mt-2">
											<p class="text-sm leading-5 text-gray-500">
												<?php _e( 'Get insights about top locations from where people are clicking on your links.', 'url-shortify' ); ?>
											</p>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>

				<!-- Referrer Info -->
				<div class="overflow-hidden rounded-lg h-px-400">
					<div class="mb-4">
						<span class="text-xl leading-6 font-medium text-gray-900"><?php _e( 'Referrers', 'url-shortify' ); ?></span>
					</div>
					<div class="bg-white border-2" id="">
						<?php 
						if ( US()->is_pro() ) {
							do_action( 'kc_us_render_referrer_info', $data );
						} else { 
							?>
							<div class="w-full h-64 p-10 bg-green-50">
								<div class="">
									<div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
										<svg class="h-12 w-12 text-green-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
											<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
										</svg>
									</div>
									<div class="mt-3 text-center sm:mt-5">
										<h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
											<?php echo sprintf( __( '<a href="%s">Upgrade Now</a>', 'url-shortify' ), US()->get_landing_page_url() ); ?>
										</h3>
										<div class="mt-2">
											<p class="text-sm leading-5 text-gray-500">
												<?php _e( 'Know who are your top referrers.', 'url-shortify' ); ?>
											</p>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Device Info, Browser Info & Platforms Info -->
		<div class="mt-6">
			<div class="grid md:grid-cols-3 sm:grid-cols-1 gap-4">

				<!-- Device Info -->
				<div class="overflow-hidden rounded-lg h-px-400">
					<div class="mb-4">
						<span class="text-xl leading-6 font-medium text-gray-900"><?php _e( 'Top Devices', 'url-shortify' ); ?></span>
					</div>
					<?php 
					if ( US()->is_pro() ) {
						do_action( 'kc_us_render_device_info', $data );
					} else { 
						?>
						<div class="w-full h-64 p-10 bg-green-50">
							<div class="">
								<div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
									<svg class="h-12 w-12 text-green-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
										<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
									</svg>
								</div>
								<div class="mt-3 text-center sm:mt-5">
									<h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
										<?php echo sprintf( __( '<a href="%s">Upgrade Now</a>', 'url-shortify' ), US()->get_landing_page_url() ); ?>
									</h3>
									<div class="mt-2">
										<p class="text-sm leading-5 text-gray-500">
											<?php _e( 'Want to know which devices were used to access your links?', 'url-shortify' ); ?>
										</p>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>

				<!-- Browser Info -->
				<div class="overflow-hidden rounded-lg h-px-400">
					<div class="mb-4">
						<span class="text-xl leading-6 font-medium text-gray-900"><?php _e( 'Top Browsers', 'url-shortify' ); ?></span>
					</div>
					<?php 
					if ( US()->is_pro() ) {
						do_action( 'kc_us_render_browser_info', $data );
					} else { 
						?>
						<div class="w-full h-64 p-10 bg-green-50">
							<div class="">
								<div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
									<svg class="h-12 w-12 text-green-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
										<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
									</svg>
								</div>
								<div class="mt-3 text-center sm:mt-5">
									<h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
										<?php echo sprintf( __( '<a href="%s">Upgrade Now</a>', 'url-shortify' ), US()->get_landing_page_url() ); ?>
									</h3>
									<div class="mt-2">
										<p class="text-sm leading-5 text-gray-500">
											<?php _e( 'Get information about browsers.', 'url-shortify' ); ?>
										</p>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>


				<!-- OS Info -->
				<div class="overflow-hidden rounded-lg h-px-400">
					<div class="mb-4">
						<span class="text-xl leading-6 font-medium text-gray-900"><?php _e( 'Top Platforms', 'url-shortify' ); ?></span>
					</div>
					<?php 
					if ( US()->is_pro() ) {
						do_action( 'kc_us_render_os_info', $data );
					} else { 
						?>
						<div class="w-full h-64 p-10 bg-green-50">
							<div class="">
								<div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
									<svg class="h-12 w-12 text-green-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
										<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
									</svg>
								</div>
								<div class="mt-3 text-center sm:mt-5">
									<h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
										<?php echo sprintf( __( '<a href="%s">Upgrade Now</a>', 'url-shortify' ), US()->get_landing_page_url() ); ?>
									</h3>
									<div class="mt-2">
										<p class="text-sm leading-5 text-gray-500">
											<?php _e( 'Know more about which devices people used to access your links.', 'url-shortify' ); ?>
										</p>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>

		<!-- Links Details -->
		<div class="mt-6 flex w-full">
			<div class="w-8/12">
				<span class="text-xl leading-6 font-medium text-gray-900"><?php _e( 'Links Info', 'url-shortify' ); ?></span>
			</div>
		</div>

		<div class="bg-white flex-grow container mx-auto sm:px-4 mt-4 pt-6 pb-8">

			<div>
				<table id="links-data" class="display" style="width:100%">
					<thead>
					<?php $links_table_controller->render_header(); ?>
					</thead>
					<tbody>
					<?php 
					foreach ( $links as $link ) {
						$links_table_controller->render_row( $link );
					} 
					?>
					</tbody>
					<tfoot>
					<?php $links_table_controller->render_footer(); ?>
					</tfoot>
				</table>
			</div>
		</div>

		<!-- Click Info -->
		<div class="mt-10 flex w-full">
			<div class="w-8/12">
				<span class="text-xl leading-6 font-medium text-gray-900"><?php _e( 'Clicks Details', 'url-shortify' ); ?></span>
			</div>
		</div>
		<div class="bg-white flex-grow container mx-auto sm:px-4 mt-4 pt-6 pb-8">

			<div>
				<table id="clicks-data" class="display" style="width:100%">
					<thead>
					<?php $click_history->render_header(); ?>
					</thead>
					<tbody>
					<?php 
					foreach ( $clicks_data as $click ) {
						$click_history->render_row( $click );
					} 
					?>
					</tbody>
					<tfoot>
					<?php $click_history->render_footer(); ?>
					</tfoot>
				</table>
			</div>
		</div>

	</div>

</div>

<script type="text/javascript">

	(function ($) {

		$(document).ready(function () {

			var labels = 
			<?php 
			if ( ! empty( $labels ) ) {
				echo $labels;
			} else {
				echo "''";
			} 
			?>
			;

			var values = 
			<?php 
			if ( ! empty( $values ) ) {
				echo $values;
			} else {
				echo "''";
			} 
			?>
			;

			if (labels != '' && values != '') {
				const data = {
					labels: labels,
					datasets: [
						{
							values: values
						},
					]
				};

				const chart = new frappe.Chart("#click-chart", {
					title: "",
					data: data,
					type: 'axis-mixed',
					colors: ['#5850ec'],
					lineOptions: {
						hideDots: 1,
						regionFill: 1
					},
					height: 250,
					axisOptions: {
						xIsSeries: true
					}
				});
			}

		});

	})(jQuery);

</script>
