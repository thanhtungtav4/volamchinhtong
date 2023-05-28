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
            <div id="iframe-id">
            <div class="form form-min pd-b-50">
                <form method="post" id="loginForm" onsubmit="handleSubmitLogin(event)">
                <h2>Đăng nhập</h2>
                <div class="hr mr-b-30"></div>
                <div class="form-group">
                    <label for="uname-login">Tài khoản *</label>
                    <input class="form-control" id="uname-login" type="text" name="login_id" value="" placeholder="Độ dài từ 6 đến 24 ký tự. Sử dụng các ký tự: a-z, 0-9">
                </div>
                <div class="form-group">
                    <label for="uname-pass">Mật khẩu *</label>
                    <input class="form-control" id="uname-pass" type="password" name="password1" value="" placeholder="Độ dài từ 6 đến 32 ký tự">
                </div>
                <div class="alert alert-danger" id="alert-danger" style="display: none;"></div>
                <div class="alert alert-success" id="alert-success" style="display: none;"></div>
                <div class="form-group">
                    <a class="forget-pass open-iframe" href="/quen-mat-khau-cap" target="_top">Quên mật khẩu?</a>
                    <a class="forget-otp pull-right" href="/quen-otp" target="_top">Quên OTP?</a>
                </div>
                <div class="form-group form-group-submit">
                    <button class="btn btn-primary" type="submit" name="submit" value="login">Đăng nhập</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div> 
<?php
    get_footer();
?>