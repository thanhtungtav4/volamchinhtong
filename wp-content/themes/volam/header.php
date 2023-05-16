<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package volam
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="võ lâm, vo lam, volam, vltk, jx1, võ lâm free, vo lam free, võ lâm miễn phí, vo lam mien phi, võ lâm private, vo lam private, võ lâm pri, vo lam pri, thân pháp, than phap, 2005, ctc, công thành chiến, cong thanh chien, võ lâm truyền kỳ, vo lam truyen ky, đồ xanh, hoàng kim, công thành, tống kim, an bang, định quốc, chính tông, hồi ức, phiên bản xanh, vo lam lau, võ lâm lậu">
    <meta name="description" content="Võ Lâm Chính Tông - Phiên bản thân pháp, chuẩn CTC 2005, cày cuốc từ level 1, lên cấp chậm, đồ xanh chủ đạo, cân bằng môn phái, hỗ trợ tân thủ tận tình. Tái hiệ">
    <meta property="og:type" content="game.achievement">
    <meta property="og:title" content="Trang chủ | Võ Lâm Chính Tông">
    <meta property="og:description" content="Võ Lâm Chính Tông - Phiên bản thân pháp, chuẩn CTC 2005, cày cuốc từ level 1, lên cấp chậm, đồ xanh chủ đạo, cân bằng môn phái, hỗ trợ tân thủ tận tình. Tái hiệ">
    <meta property="og:image" content="<?php echo get_stylesheet_directory_uri() ?>/assets/images/600x315.jpg">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="315">
    <link rel="shortcut icon" href="favicon.ico">
    <title>Võ Lâm Chính Tông - Phiên bản thân pháp, chuẩn Võ Lâm Truyền Kỳ Công Thành Chiến 2005</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri() ?>/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri() ?>/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri() ?>/assets/css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri() ?>/assets/css/jquery.fancybox.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri() ?>/assets/css/style.css">
    <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/jquery.mCustomScrollbar.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/jquery.fancybox.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/jquery.cookie.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/sweetalert2.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/common.js"></script>
	<?php wp_head(); ?>
</head>
    <div class="wrapper home">
      <div class="wrapper-inner">
        <div class="header">
          <div class="nav">
            <a href="#" class="swapmenu"></a>
            <a href="/">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/logo.png" alt="Võ Lâm Chính Tông" class="logo">
            </a>
            <?php if (has_nav_menu( 'primary_menu' )) {
                wp_nav_menu( array(
                'container'         => 'false',
                'menu_class'        => 'nav-menu',
                'items_wrap'        => '<ul class="%2$s" role="menubar">%3$s</ul>',
                'theme_location'    => 'primary_menu' ) );
            } ?>
            <a href="#" class="btn-login">Tài khoản</a>
            <div class="menu-mobile">
              <?php if (has_nav_menu( 'primary_menu' )) {
                  wp_nav_menu( array(
                  'container'         => 'false',
                  'menu_class'        => 'nav-menu',
                  'items_wrap'        => '<ul class="%2$s" role="menubar">%3$s</ul>',
                  'theme_location'    => 'primary_menu' ) );
              } ?>
            </div>
          </div>
        </div>
        <script type="text/javascript">
          $(document).ready(function() {
            $('.nav li').removeClass('active');
            $('.nav li a[href="/"]').addClass('active');
            $('.nav li a[href="/"]').parents('li').addClass('active');
          })
        </script>
        <div class="content-main">