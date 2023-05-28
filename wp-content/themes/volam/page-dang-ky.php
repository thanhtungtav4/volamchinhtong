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
                <form method="post" id="RegisterForm" onsubmit="handleSubmitRegister(event)">
                    <h2>ĐĂNG KÝ TÀI KHOẢN</h2>
                    <div class="hr mr-b-30"></div>
                    <div class="form-group">
                        <label for="name">Tên *</label>
                        <input class="form-control" id="name" type="text" name="name" value="" placeholder="Độ dài từ 6 đến 32 ký tự">
                    </div>
                    <div class="form-group">
                        <label for="login_id">ID Đăng nhập *</label>
                        <input class="form-control" id="login_id" type="text" name="login_id" value="" placeholder="Độ dài từ 6 đến 32 ký tự">
                    </div>
                    <div class="form-group">
                        <label for="password1">Mật khẩu Cấp 1*</label>
                        <input class="form-control" id="password1" type="password" name="password1" value="" placeholder="Độ dài từ 6 đến 32 ký tự">
                    </div>
                    <div class="form-group">
                        <label for="password1_confirmation">Xác Nhận Mật khẩu Cấp 1*</label>
                        <input class="form-control" id="password1_confirmation" type="password" name="password1_confirmation" value="" placeholder="Độ dài từ 6 đến 32 ký tự">
                    </div>
                    <div class="form-group">
                        <label for="password2">Mật khẩu Cấp 2*</label>
                        <input class="form-control" id="password2" type="password" name="password2" value="" placeholder="Độ dài từ 6 đến 32 ký tự">
                    </div>
                    <div class="form-group">
                        <label for="password2_confirmation">Xác Nhận Mật khẩu Cấp 2*</label>
                        <input class="form-control" id="password2_confirmation" type="password" name="password2_confirmation" value="" placeholder="Độ dài từ 6 đến 32 ký tự">
                    </div>
                    <div class="alert alert-danger" id="alert-danger" style="display: none;"></div>
                    <div class="alert alert-success" id="alert-success" style="display: none;"></div>

                    <div class="form-group form-group-submit">
                        <button class="btn btn-primary" type="submit" name="submit">Đăng Ký</button>
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