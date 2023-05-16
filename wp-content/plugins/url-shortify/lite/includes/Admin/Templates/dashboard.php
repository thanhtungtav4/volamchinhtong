<?php

use Kaizen_Coders\Url_Shortify\Admin\Controllers\ClicksController;
use Kaizen_Coders\Url_Shortify\Common\Utils;
use Kaizen_Coders\Url_Shortify\Helper;

$page_refresh_url = Utils::get_current_page_refresh_url();

$last_updated_on = Helper::get_data( $data, 'last_updated_on', time() );

$elapsed_time = Utils::get_elapsed_time( $last_updated_on );

$show_kpis     = Helper::get_data( $data, 'show_kpis', false );
$new_link_url  = Helper::get_data( $data, 'new_link_url', '' );
$new_group_url = Helper::get_data( $data, 'new_group_url', '' );

$show_landing_page = Helper::get_request_data('landing', false);

if ( $show_kpis && ! $show_landing_page) {

	$kpis = Helper::get_data( $data, 'kpis', array() );

	$clicks_data = $data['reports']['clicks'];

	$click_data_for_graph = $data['click_data_for_graph'];

	$labels = $values = '';
	if ( ! empty( $click_data_for_graph ) ) {
		$labels = json_encode( array_keys( $click_data_for_graph ) );

		$clicks = array_values( $click_data_for_graph );

		$total_clicks = array_sum( $clicks );

		$values = json_encode( $clicks );

	}

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

	?>

	<div class="wrap" id="">
		<header class="mx-auto">
			<div class="pb-5 border-b border-gray-300 md:flex md:items-center md:justify-between">
				<div class="flex-1 min-w-0">
					<h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
						<?php _e( 'Dashboard', 'url-shortify' ); ?>
					</h2>
				</div>
				<div class="flex mt-4 md:mt-0 md:ml-4" x-data="dropdown()">
					<span class="rounded-md shadow-sm">
						<button type="button" class="w-full text-white bg-green-500 kc-us-primary-button hover:bg-green-400" title="<?php echo sprintf(__('Last Updated On: %s', 'url-shortify'), $elapsed_time ); ?>">
							<a href="<?php echo $page_refresh_url; ?>" class="text-white hover:text-white"><?php _e('Refresh', 'url-shortify'); ?></a>
						</button>
					</span>
					<span class="ml-3 rounded-md shadow-sm">
						<div id="kc-us-create-button" class="relative inline-block text-left">
							<div>
							  <span class="rounded-md shadow-sm">
								<button type="button" class="w-full kc-us-primary-button" x-on:click="open">
								  <?php _e( 'Create', 'url-shortify' ); ?>
								  <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
								  </svg>
								</button>
							  </span>
							</div>
							<div x-show="isOpen()" id="kc-us-create-dropdown" class="absolute right-0 hidden w-56 mt-2 origin-top-right rounded-md shadow-lg">
							  <div class="bg-white rounded-md shadow-xs">
								<div class="py-1">
								  <a href="<?php echo $new_link_url; ?>" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"><?php _e( 'New Link', 'url-shortify' ); ?></a>
								  <a href="<?php echo $new_group_url; ?>" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"><?php _e( 'New Group', 'url-shortify' ); ?></a>
								</div>
							  </div>
							</div>
						</div>
					</span>
				</div>
			</div>
		</header>

		<!-- KPI -->
		<div class="mt-5">
			<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
				<?php foreach ( $kpis as $kpi ) { ?>
					<?php 
					if ( ! empty( $kpi['url'] ) ) {
						?>
						<a href="<?php echo $kpi['url']; ?>" target="_blank"> <?php } ?>
					<div class="overflow-hidden bg-white rounded-lg shadow">
						<div class="px-4 py-5 sm:p-6">
							<div class="flex items-center">
								<div class="flex-shrink-0 p-3 bg-indigo-500 rounded-md">
									<svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<?php echo $kpi['icon']; ?>
									</svg>
								</div>
								<div class="flex-1 w-0 ml-5">
									<dl>
										<dt class="text-sm font-medium leading-5 text-gray-500 truncate">
											<?php echo $kpi['title']; ?>
										</dt>
										<dd class="flex items-baseline">
											<div class="text-2xl font-semibold leading-8 text-gray-900">
												<?php echo $kpi['count']; ?>
											</div>
										</dd>
									</dl>
								</div>
							</div>
						</div>
					</div>
					<?php 
					if ( ! empty( $kpi['url'] ) ) {
						?>
						 </a> <?php } ?>
				<?php } ?>
			</div>
		</div>
		<!-- KPI END -->

		<!-- Click History Report -->
		<div class="mt-4">
			<div class="grid grid-cols-1 mt-5">
				<div class="flex w-full mt-2 border-b-2 border-gray-100">
					<div class="w-9/12">
						<span class="text-xl font-medium leading-6 text-gray-900"><?php _e( 'Clicks History', 'url-shortify' ); ?></span>
						<p class="max-w-2xl mt-1 mb-2 text-sm leading-5 text-gray-500"><?php echo sprintf( __( '%d Total Clicks', 'url-shortify' ), $total_clicks ); ?></p>
					</div>
				</div>
				<!-- Click Chart will draw here -->
				<div class="mt-2 bg-white" id="click-chart">

				</div>
			</div>
		</div>

		<!-- Country & Referrer Info -->
		<div class="mt-6">
			<div class="grid gap-4 md:grid-cols-2 sm:grid-cols-1">
				<!-- Country Info -->
				<div class="overflow-hidden rounded-lg">

					<div class="mb-4">
						<span class="text-xl font-medium leading-6 text-gray-900"><?php _e( 'Top Locations', 'url-shortify' ); ?></span>
					</div>

					<div class="bg-white border-2">
						<?php 
						if ( US()->is_pro() ) {
							do_action( 'kc_us_render_country_info', $data );
						} else { 
							?>
							<div class="w-full h-64 p-10 bg-green-50">
								<div class="">
									<div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full">
										<svg class="w-12 h-12 text-green-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
											<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
										</svg>
									</div>
									<div class="mt-3 text-center sm:mt-5">
										<h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-headline">
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
						<span class="text-xl font-medium leading-6 text-gray-900"><?php _e( 'Referrers', 'url-shortify' ); ?></span>
					</div>
					<div class="bg-white border-2" id="">
						<?php 
						if ( US()->is_pro() ) {
							do_action( 'kc_us_render_referrer_info', $data );
						} else { 
							?>
							<div class="w-full h-64 p-10 bg-green-50">
								<div class="">
									<div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full">
										<svg class="w-12 h-12 text-green-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
											<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
										</svg>
									</div>
									<div class="mt-3 text-center sm:mt-5">
										<h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-headline">
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
			<div class="grid gap-4 md:grid-cols-3 sm:grid-cols-1">

				<!-- Device Info -->
				<div class="overflow-hidden rounded-lg h-px-400">
					<div class="mb-4">
						<span class="text-xl font-medium leading-6 text-gray-900"><?php _e( 'Top Devices', 'url-shortify' ); ?></span>
					</div>
					<?php 
					if ( US()->is_pro() ) {
						do_action( 'kc_us_render_device_info', $data );
					} else { 
						?>
						<div class="w-full h-64 p-10 bg-green-50">
							<div class="">
								<div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full">
									<svg class="w-12 h-12 text-green-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
										<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
									</svg>
								</div>
								<div class="mt-3 text-center sm:mt-5">
									<h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-headline">
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
						<span class="text-xl font-medium leading-6 text-gray-900"><?php _e( 'Top Browsers', 'url-shortify' ); ?></span>
					</div>
					<?php 
					if ( US()->is_pro() ) {
						do_action( 'kc_us_render_browser_info', $data );
					} else { 
						?>
						<div class="w-full h-64 p-10 bg-green-50">
							<div class="">
								<div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full">
									<svg class="w-12 h-12 text-green-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
										<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
									</svg>
								</div>
								<div class="mt-3 text-center sm:mt-5">
									<h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-headline">
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
						<span class="text-xl font-medium leading-6 text-gray-900"><?php _e( 'Top Platforms', 'url-shortify' ); ?></span>
					</div>
					<?php 
					if ( US()->is_pro() ) {
						do_action( 'kc_us_render_os_info', $data );
					} else { 
						?>
						<div class="w-full h-64 p-10 bg-green-50">
							<div class="">
								<div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full">
									<svg class="w-12 h-12 text-green-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
										<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
									</svg>
								</div>
								<div class="mt-3 text-center sm:mt-5">
									<h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-headline">
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

		<!-- Click History -->
		<div class="flex w-full mt-6">
			<div class="w-8/12">
				<span class="text-xl font-medium leading-6 text-gray-900"><?php _e( 'Clicks Details', 'url-shortify' ); ?></span>
			</div>
		</div>
		<div class="container flex-grow pt-6 pb-8 mx-auto mt-4 bg-white sm:px-4">

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


<?php } else {
        include_once 'landing.php';
} ?>


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
