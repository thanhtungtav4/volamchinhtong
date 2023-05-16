<?php

use Kaizen_Coders\Url_Shortify\Helper;

$nav_menus = Helper::get_data( $template_data, 'links', array() );

$tab = ! empty( $_GET['tab'] ) ? Helper::clean( $_GET['tab'] ) : 'import';

$action = ! empty( $_GET['action'] ) ? Helper::clean( $_GET['action'] ) : '';

$current_url = \Kaizen_Coders\Url_Shortify\Common\Utils::get_current_page_url();

$nonce = wp_create_nonce( 'kc_us_import' );

$valid_imports = array( 'csv', 'pretty_links', 'mts_links', 'eps_301_redirects', 'simple_301_redirects', 'thirsty_affiliates', 'shorten_url' );

$current_url = add_query_arg( 'nonce', $nonce, $current_url );

$received_nonce   = ! empty( $_GET['nonce'] ) ? sanitize_text_field( wp_unslash( $_GET['nonce'] ) ) : '';
$is_valid_request = wp_verify_nonce( $received_nonce, 'kc_us_import' );

$import_status = Helper::get_request_data( 'import_status', '' );

?>

<div class="wrap">
    <h2>Tools</h2>
    <h2 class="nav-tab-wrapper">
		<?php foreach ( $nav_menus as $id => $menu ) { ?>
            <a href="<?php echo $menu['link']; ?>" class="nav-tab wpsf-tab-link <?php if ( $id === $tab ) {
				echo "nav-tab-active";
			} ?>">
				<?php echo $menu['title']; ?>
            </a>
		<?php } ?>
    </h2>

    <div class="bg-white shadow-md meta-box-sortables">



        <!-- First Screen - List all import section -->
		<?php

		$submitted = Helper::get_request_data( 'submitted', '' );

        if ( 'import' === $tab && '' === $action ) {

			$import_from = array(
				array(
					'title'  => __( 'Import CSV', 'url-shortify' ),
					'action' => 'csv',
					'show'   => true,
				),

                array(
					'title'  => sprintf( __( 'Import Short Links From <a href="%s" target="_blank">Pretty Links</a> WordPress Plugin', 'url-shortify' ), 'https://wordpress.org/plugins/prettylinks' ),
					'action' => 'pretty_links',
					'show'   => Helper::is_pretty_links_table_exists()
				),

				array(
					'title'  => sprintf( __( 'Import Short Links From <a href="%s" target="_blank">URL Shortener by MyThemeShop</a> WordPress Plugin', 'url-shortify' ), 'https://wordpress.org/plugins/mts-url-shortener/' ),
					'action' => 'mts_links',
					'show'   => Helper::is_mts_short_links_table_exists()
				),

				array(
					'title' => sprintf( __( 'Import Short Links From <a href="%s" target="_blank">301 Redirect</a> WordPress Plugin', 'url-shortify' ), 'https://wordpress.org/plugins/eps-301-redirects/' ),
                    'action' => 'eps_301_redirects',
					'show'  => Helper::is_301_redirect_table_exists()
                ),

                array(
	                'title'  => sprintf( __( 'Import Short Links From <a href="%s" target="_blank">Simple 301 Redirect</a> WordPress Plugin', 'url-shortify' ), 'https://wordpress.org/plugins/simple-301-redirects/' ),
	                'action' => 'simple_301_redirects',
	                'show'   => Helper::is_simple_301_redirect_plugin_installed()
                ),

                array(
	                'title'  => sprintf( __( 'Import Short Links From <a href="%s" target="_blank">Short URL</a> WordPress Plugin', 'url-shortify' ), 'https://wordpress.org/plugins/shorten-url/' ),
	                'action' => 'shorten_url',
	                'show'   => Helper::is_shorten_url_table_exists()
                ),

                array(
	                'title'  => sprintf( __( 'Import Short Links From <a href="%s" target="_blank">Thirsty Affiliates</a> WordPress Plugin', 'url-shortify' ), 'https://wordpress.org/plugins/simple-301-redirects/' ),
	                'action' => 'thirsty_affiliates',
	                'show'   => Helper::is_thirstry_affiliates_installed()
                ),

			);



			if ( 'success' === $import_status ) { ?>
                <div class="notice notice-success is-dismissible"><p><?php _e( 'Import successfully completed!' ); ?></p></div>
			<?php } elseif ( 'error' === $import_status ) { ?>
                <div class="notice notice-error is-dismissible"><p><?php _e( 'Error occurred!' ); ?></p></div>
			<?php } ?>

            <?php foreach ( $import_from as $item ) {

				if ( true == $item['show'] ) { ?>
                    <div class="flex-row pt-2 pb-2 ml-5 mr-4 text-left item-center">
                        <div class="flex flex-row border-b border-gray-100">
                            <div class="flex w-4/5">
                                <label for="">
                            <span class="block pt-1 mb-2 pr-4 ml-4 text-sm font-medium text-gray-600">
                                <?php echo $item['title']; ?>
                            </span>
                                </label>
                            </div>
                            <div class="flex w-1/5">
                                <a href="<?php echo esc_url_raw( $current_url ) . '&action=' . $item['action']; ?>" class="px-4 py-2 mx-2 my-2 text-sm font-medium leading-5 align-middle transition duration-150 ease-in-out border border-indigo-600 rounded-md cursor-pointer hover:shadow-md focus:outline-none focus:shadow-outline-indigo">
                                    <?php _e( 'Import', 'url-shortify' ); ?>
                                </a>
                            </div>
                        </div>
                    </div>
				<?php }
			} ?>

		<?php } elseif ( 'bookmarklet' === $tab && '' === $action ) {
            // Generate bookmarklet page from PRO.
            do_action('kc_us_render_bookmarklet_page');

        } elseif ( 'import' === $tab && 'csv' === $action && ('' === $submitted)) { ?>

            <div class="flex-row pt-2 pb-2 ml-5 mr-4 text-left item-center">
                <div class="flex flex-row border-b border-gray-100">
                    <form method="post" enctype="multipart/form-data">
		                <?php
		                // Security check for nonces
		                wp_nonce_field( 'import_csv');
		                ?>

                        <p>
                            <label for="csv_file">Select CSV file to import:</label><br>
                            <input type="file" name="csv_file" id="csv_file">
                        </p>

                        <input type="hidden" name="submitted" value="submitted"/>

		                <?php
		                // Submit button
		                submit_button( 'Import CSV' );

                        $max_upload_size = Helper::get_max_upload_size();

                        ?>

                        <p class="mt-2 kc-us-helper-text">
                            <?php
                                echo sprintf( esc_html__( 'File size should be less than %s', 'email-subscribers' ), esc_html( size_format( $max_upload_size ) ) );
                            ?>
                            </p>
                            <p class="mt-2 kc-us-helper-text">
                                <?php esc_html_e( 'Check CSV structure', 'email-subscribers' ); ?>
                                <a class="font-medium hover:underline" target="_blank" href="<?php echo esc_attr( plugin_dir_url( __FILE__ ) ) . '../../Admin/Templates/sample.csv'; ?>"><?php esc_html_e( 'from here', 'email-subscribers' ); ?></a>
                            </p>
                    </form>
                </div>
            </div>

		<?php } elseif ( 'import' === $tab && in_array( $action, $valid_imports ) && $is_valid_request ) {

			$import    = new \Kaizen_Coders\Url_Shortify\Admin\Controllers\ImportController();
			$do_import = $import->import_links( $action );

			$current_url = remove_query_arg( 'action' );
			if ( $do_import ) {
				$current_url = add_query_arg( array( 'import_status' => 'success' ), $current_url );
			} else {
				$current_url = add_query_arg( array( 'import_status' => 'error' ), $current_url );
			}

			wp_safe_redirect( $current_url );
			exit;
		} ?>


    </div>

</div>
