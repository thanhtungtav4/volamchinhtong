<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

  get_header();
?> 
    <div class="content-main">
    <div class="content-left">
        <div class="iframe-id">
            <div class="wrap-iframe">
                <?php require_once( get_stylesheet_directory() . '/module/user-menu-left.php' ); ?>
            </div>
        </div>
    </div>
    <div class="content-center">
        <div class="iframe-id">
            <div class="wrap-iframe">
            <div class="form pd-b-50 form-user">
                <h2>Thông tin tài khoản</h2>
                <div class="hr mr-b-30"></div>
                <table class="table table-striped user-info-table">
                    <tbody>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
    </div> 
<?php
    get_footer();
?>