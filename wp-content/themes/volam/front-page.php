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

    <div class="content-left">
    <div class="block-user-account">
        <a href="https://volamchinhtong.com/download" class="download">
        <video width="310" height="160" preload loop muted autoplay poster>
            <source src="media/btn-download.mp4" type="video/mp4">
            <!-- <source src="//volamchinhtong.com/st/mainsite/video/download-game.webm" type="video/webm"> -->
        </video>
        </a>
        <div class="clip">
        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/download.jpg" alt="Download client">
        </div>
        <div class="reglog">
        <a href="https://volamchinhtong.com/dang-ky" class="reg " data-task="login"></a>
        <a href="https://volamchinhtong.com/tin-tuc/nap-the.html" class="log "></a>
        </div>
        <a href="https://volamchinhtong.com/thong-tin-ca-nhan" class="user-account widget-login" data-task="login"></a>
        <span class="user-account"></span>
    </div>
    <div class="group">
        <h3>Group</h3>
        <div class="group-inner" style="min-height: 254px">
        <script>
            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId=2537659453160969&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <div class="fb-group" data-href="https://www.facebook.com/groups/volamchinhtong2005" data-width="305" data-show-social-context="true" data-show-metadata="true">Nhóm Facebook Võ Lâm Chính Tông</div>
        </div>
    </div>
    <div class="daily">
        <h3>
        <span>Hoạt động ngày</span>
        </h3>
        <div class="daily-inner">
        <div class="tabs">
            <ul>
            <li class="tabs-item day-name-1">
                <a href="#" data-day="t2">T2</a>
            </li>
            <li class="tabs-item day-name-2">
                <a href="#" data-day="t3">T3</a>
            </li>
            <li class="tabs-item day-name-3">
                <a href="#" data-day="t4">T4</a>
            </li>
            <li class="tabs-item day-name-4">
                <a href="#" data-day="t5">T5</a>
            </li>
            <li class="tabs-item day-name-5">
                <a href="#" data-day="t6">T6</a>
            </li>
            <li class="tabs-item day-name-6">
                <a href="#" data-day="t7">T7</a>
            </li>
            <li class="tabs-item day-name-7">
                <a href="#" data-day="cn">CN</a>
            </li>
            </ul>
        </div>
        <div class="daily-content">
            <div class="day t2">
            <div class="content">
                <div class="item">
                <div class="name"> Dã Tẩu</div>
                <div class="time"> Cả ngày</div>
                </div>
                <div class="item">
                <div class="name"> Vượt Ải</div>
                <div class="time"> Đầu mỗi giờ</div>
                </div>
                <div class="item">
                <div class="name"> Phong Lăng Độ</div>
                <div class="time"> 1,11,14,16,17,22</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu (S1 S2)</div>
                <div class="time"> 11:00</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 12:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 12:30</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 13:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 15:00</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu</div>
                <div class="time"> 18:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 19:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 19:30</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Hoàng Kim</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> PLD (Đặc biệt)</div>
                <div class="time"> 20:25</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (1 account/IP)</div>
                <div class="time"> 21:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 23:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 23:00</div>
                </div>
                <p> &nbsp;</p>
            </div>
            </div>
            <div class="day t3" style="display: block;">
            <div class="content">
                <div class="item">
                <div class="name"> Dã Tẩu</div>
                <div class="time"> Cả ngày</div>
                </div>
                <div class="item">
                <div class="name"> Vượt Ải</div>
                <div class="time"> Đầu mỗi giờ</div>
                </div>
                <div class="item">
                <div class="name"> Phong Lăng Độ</div>
                <div class="time"> 1,11,14,16,17,22</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu&nbsp;(S1 S2)</div>
                <div class="time"> 11:00</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 12:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 12:30</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 13:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 15:00</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu</div>
                <div class="time"> 18:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 19:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 19:30</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Hoàng Kim</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> PLD (Đặc biệt)</div>
                <div class="time"> 20:25</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (1 account/IP)</div>
                <div class="time"> 21:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 23:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 23:00</div>
                </div>
                <p> &nbsp;</p>
            </div>
            </div>
            <div class="day t4">
            <div class="content">
                <div class="item">
                <div class="name"> Dã Tẩu</div>
                <div class="time"> Cả ngày</div>
                </div>
                <div class="item">
                <div class="name"> Vượt Ải</div>
                <div class="time"> Đầu mỗi giờ</div>
                </div>
                <div class="item">
                <div class="name"> Phong Lăng Độ</div>
                <div class="time"> 1,11,14,16,17,22</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu&nbsp;(S1 S2)</div>
                <div class="time"> 11:00</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 12:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 12:30</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 13:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 15:00</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu</div>
                <div class="time"> 18:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 19:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 19:30</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Hoàng Kim</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> PLD (Đặc biệt)</div>
                <div class="time"> 20:25</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (1 account/IP)</div>
                <div class="time"> 21:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 23:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 23:00</div>
                </div>
                <p> &nbsp;</p>
            </div>
            </div>
            <div class="day t5">
            <div class="content">
                <div class="item">
                <div class="name"> Dã Tẩu</div>
                <div class="time"> Cả ngày</div>
                </div>
                <div class="item">
                <div class="name"> Vượt Ải</div>
                <div class="time"> Đầu mỗi giờ</div>
                </div>
                <div class="item">
                <div class="name"> Phong Lăng Độ</div>
                <div class="time"> 1,11,14,16,17,22</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu&nbsp;(S1 S2)</div>
                <div class="time"> 11:00</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 12:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 12:30</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 13:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 15:00</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu</div>
                <div class="time"> 18:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 19:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 19:30</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Hoàng Kim</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> PLD (Đặc biệt)</div>
                <div class="time"> 20:25</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (1 account/IP)</div>
                <div class="time"> 21:00</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu</div>
                <div class="time"> 22:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 23:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 23:00</div>
                </div>
                <p> &nbsp;</p>
            </div>
            </div>
            <div class="day t6">
            <div class="content">
                <div class="item">
                <div class="name"> Dã Tẩu</div>
                <div class="time"> Cả ngày</div>
                </div>
                <div class="item">
                <div class="name"> Nhiệm vụ Bắc Đẩu</div>
                <div class="time"> Cả ngày</div>
                </div>
                <div class="item">
                <div class="name"> Vượt Ải</div>
                <div class="time"> Đầu mỗi giờ</div>
                </div>
                <div class="item">
                <div class="name"> Phong Lăng Độ</div>
                <div class="time"> 1,11,14,16,17,22</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu&nbsp;(S1 S2)</div>
                <div class="time"> 11:00</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 12:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 12:30</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 13:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 15:00</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu</div>
                <div class="time"> 18:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 19:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 19:30</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Hoàng Kim</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> PLD (Đặc biệt)</div>
                <div class="time"> 20:25</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (1 account/IP)</div>
                <div class="time"> 21:00</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu</div>
                <div class="time"> 22:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 23:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 23:00</div>
                </div>
                <p> &nbsp;</p>
            </div>
            </div>
            <div class="day t7">
            <div class="content">
                <div class="item">
                <div class="name"> Dã Tẩu</div>
                <div class="time"> Cả ngày</div>
                </div>
                <div class="item">
                <div class="name"> Nhiệm vụ Bắc Đẩu</div>
                <div class="time"> Cả ngày</div>
                </div>
                <div class="item">
                <div class="name"> Vượt Ải</div>
                <div class="time"> Đầu mỗi giờ</div>
                </div>
                <div class="item">
                <div class="name"> Phong Lăng Độ</div>
                <div class="time"> 1,11,14,16,17,22</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 12:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 12:30</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 13:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 15:00</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu</div>
                <div class="time"> 18:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 19:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 19:30</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Hoàng Kim</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> PLD (Đặc biệt)</div>
                <div class="time"> 20:25</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (1 account/IP)</div>
                <div class="time"> 21:00</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu</div>
                <div class="time"> 22:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 23:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 23:00</div>
                </div>
                <p> &nbsp;</p>
            </div>
            </div>
            <div class="day cn">
            <div class="content">
                <div class="item">
                <div class="name"> Dã Tẩu</div>
                <div class="time"> Cả ngày</div>
                </div>
                <div class="item">
                <div class="name"> Nhiệm vụ Bắc Đẩu</div>
                <div class="time"> Cả ngày</div>
                </div>
                <div class="item">
                <div class="name"> Vượt Ải</div>
                <div class="time"> Đầu mỗi giờ</div>
                </div>
                <div class="item">
                <div class="name"> Phong Lăng Độ</div>
                <div class="time"> 1,11,14,16,17,22</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 12:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 12:30</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 13:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 15:00</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu</div>
                <div class="time"> 18:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 19:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Đại Hoàng Kim</div>
                <div class="time"> 19:30</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Huy Hoàng</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> Hái Quả Hoàng Kim</div>
                <div class="time"> 20:00</div>
                </div>
                <div class="item">
                <div class="name"> PLD (Đặc biệt)</div>
                <div class="time"> 20:25</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (1 account/IP)</div>
                <div class="time"> 21:00</div>
                </div>
                <div class="item">
                <div class="name"> Liên Đấu</div>
                <div class="time"> 22:00</div>
                </div>
                <div class="item">
                <div class="name"> Boss Tiểu Hoàng Kim</div>
                <div class="time"> 23:00</div>
                </div>
                <div class="item">
                <div class="name"> Tống Kim (Ngẫu nhiên phe)</div>
                <div class="time"> 23:00</div>
                </div>
                <p> &nbsp;</p>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="content-center">
    <div class="slide">
        <div class="owl-carousel">
        <div class="item">
            <a href="https://volamchinhtong.com/tin-tuc/huong-dan-su-dung-auto-tinhlagi.html" target="_blank">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/tlg_628.png" alt="Đua Top" onerror="this.src='//volamchinhtong.com/st/mainsite/imgs/slide-1.jpg';">
            </a>
        </div>
        <div class="item">
            <a href="https://volamchinhtong.com/tin-tuc/chuoi-su-kien-mung-dai-le-30-4-2023.html" target="_blank">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/3042023_628x178.jpg" alt="duatopbang" onerror="this.src='//volamchinhtong.com/st/mainsite/imgs/slide-1.jpg';">
            </a>
        </div>
        <div class="item">
            <a href="https://volamchinhtong.com/tin-tuc/khai-mo-s6-tieu-son-14-04-2023.html" target="_blank">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/S6_628x178.jpg" alt="GĐVL" onerror="this.src='//volamchinhtong.com/st/mainsite/imgs/slide-1.jpg';">
            </a>
        </div>
        <div class="item">
            <a href="https://volamchinhtong.com/tin-tuc/huong-dan-nap-the.html" target="_blank">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/hdnapthe.png" alt="OB1" onerror="this.src='//volamchinhtong.com/st/mainsite/imgs/slide-1.jpg';">
            </a>
        </div>
        <div class="item">
            <a href="https://volamchinhtong.com/tin-tuc/bao-mat-tai-khoan-theo-ma-may.html" target="_blank">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/baomatmm_628x178.jpg" alt="goidautu_ms" onerror="this.src='//volamchinhtong.com/st/mainsite/imgs/slide-1.jpg';">
            </a>
        </div>
        <div class="item">
            <a href="	https://volamchinhtong.com/tin-tuc/bao-mat.html" target="_blank">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/baomatmm_628x178.jpg" alt="Promotion" onerror="this.src='//volamchinhtong.com/st/mainsite/imgs/slide-1.jpg';">
            </a>
        </div>
        <div class="item">
            <a href="https://volamchinhtong.com//tin-tuc/chim-se-di-nang-va-vlct.html" target="_blank">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/618.png" alt="CSDN" onerror="this.src='//volamchinhtong.com/st/mainsite/imgs/slide-1.jpg';">
            </a>
        </div>
        </div>
    </div>
    <div class="news">
        <div class="nav">
        <ul>
            <li>
            <a href="/tin-tuc">Tin tức</a>
            </li>
            <li>
            <a href="/su-kien">Sự kiện</a>
            </li>
            <li>
            <a href="/huong-dan">Hướng dẫn</a>
            </li>
        </ul>
        <form class="search-lite">
            <input type="text" placeholder="Nhập từ khóa tìm kiếm">
            <button type="submit">+</button>
        </form>
        </div>
        <div class="list-news">
        <div class="item hot">
            <div class="cover">
            <a href="/tin-tuc/dua-top-bang-hoi-da-tau.html" target="_blank" title="ĐUA TOP BANG HỘI - DÃ TẨU">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/duatopbh_DT_287.png" alt="ĐUA TOP BANG HỘI - DÃ TẨU" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
            </a>
            </div>
            <div class="detail">
            <a href="/tin-tuc/dua-top-bang-hoi-da-tau.html" target="_blank" alt="ĐUA TOP BANG HỘI - DÃ TẨU">
                <h3 title="ĐUA TOP BANG HỘI - DÃ TẨU">ĐUA TOP BANG HỘI - DÃ TẨU</h3>
            </a>
            <span class="time">15/05/2023</span>
            <p class="desc">Sự kiện Đua Top Bang Hội lần này sẽ chỉ tập trung vào hoạt động Dã Tẩu sẽ là một hoạt động thú vị. Ngoài Vượt Ải và Dã Tẩu thì sắp tới sẽ có đua top TK và PLD để hấp dẫn hơn</p>
            <a href="/tin-tuc/dua-top-bang-hoi-da-tau.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
        </div>
        <div class="list">
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/tinh-nang-vuot-ai.html" target="_blank" title="TÍNH NĂNG VƯỢT ẢI">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thumbfb-VA.png" alt="TÍNH NĂNG VƯỢT ẢI" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/tinh-nang-vuot-ai.html" target="_blank" alt="TÍNH NĂNG VƯỢT ẢI">
                <h3 title="TÍNH NĂNG VƯỢT ẢI">TÍNH NĂNG VƯỢT ẢI</h3>
                </a>
                <span class="time">12/05/2023</span>
                <p class="desc">Tham gia Vượt Ải đòi hỏi sự khéo léo, lòng gan dạ và sự phối hợp giữa các thành viên tham gia. Mỗi cửa ải được bày bố một hệ thống quái vật dày đặc và đặc trưng riêng cho mỗi ải.</p>
                <a href="/tin-tuc/tinh-nang-vuot-ai.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/bao-tri-may-chu-ngay-15-5.html" target="_blank" title="BẢO TRÌ MÁY CHỦ NGÀY 15/5">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thumb-btdk.png" alt="BẢO TRÌ MÁY CHỦ NGÀY 15/5" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/bao-tri-may-chu-ngay-15-5.html" target="_blank" alt="BẢO TRÌ MÁY CHỦ NGÀY 15/5">
                <h3 title="BẢO TRÌ MÁY CHỦ NGÀY 15/5">BẢO TRÌ MÁY CHỦ NGÀY 15/5</h3>
                </a>
                <span class="time">08/05/2023</span>
                <p class="desc">Võ Lâm Chính Tông sẽ tiến hành bảo trì định kỳ tất cả máy chủ từ 16h05 - 17h00 để bảo dưỡng hệ thống máy chủ đồng thời cập nhật nội dung mới. Mong chư vị anh hùng sắp xếp thời gian bôn tẩu...</p>
                <a href="/tin-tuc/bao-tri-may-chu-ngay-15-5.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/s6-dua-top-tong-kim.html" target="_blank" title="S6 - ĐUA TOP TỐNG KIM">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/duatoptk_287x184.png" alt="S6 - ĐUA TOP TỐNG KIM" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/s6-dua-top-tong-kim.html" target="_blank" alt="S6 - ĐUA TOP TỐNG KIM">
                <h3 title="S6 - ĐUA TOP TỐNG KIM">S6 - ĐUA TOP TỐNG KIM</h3>
                </a>
                <span class="time">08/05/2023</span>
                <p class="desc">Sự kiện Đua Top Tống Kim tại S6 Tiêu Sơn sẽ diễn ra vào lúc 21h mỗi ngày từ 08/5 đến 14/5. Hãy cùng tham gia để nhận được những phần quà hấp dẫn nhé!</p>
                <a href="/tin-tuc/s6-dua-top-tong-kim.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/chien-truong-tong-kim.html" target="_blank" title="S6 - CHIẾN TRƯỜNG TỐNG KIM">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thumbfb-TK.png" alt="S6 - CHIẾN TRƯỜNG TỐNG KIM" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/chien-truong-tong-kim.html" target="_blank" alt="S6 - CHIẾN TRƯỜNG TỐNG KIM">
                <h3 title="S6 - CHIẾN TRƯỜNG TỐNG KIM">S6 - CHIẾN TRƯỜNG TỐNG KIM</h3>
                </a>
                <span class="time">08/05/2023</span>
                <p class="desc">Cho dù ở thời kỳ nào thì chiến trường Tống Kim luôn sôi động và nảy lửa. Không chỉ là sự tranh tài giữa các cá nhân mà còn là của những bang hội trong game</p>
                <a href="/tin-tuc/chien-truong-tong-kim.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/cap-nhat-tinh-nang.html" target="_blank" title="NHỮNG NỘI DUNG ĐÃ CẬP NHẬT">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/updated_287x184.png" alt="NHỮNG NỘI DUNG ĐÃ CẬP NHẬT" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/cap-nhat-tinh-nang.html" target="_blank" alt="NHỮNG NỘI DUNG ĐÃ CẬP NHẬT">
                <h3 title="NHỮNG NỘI DUNG ĐÃ CẬP NHẬT">NHỮNG NỘI DUNG ĐÃ CẬP NHẬT</h3>
                </a>
                <span class="time">05/05/2023</span>
                <p class="desc">Võ Lâm Chính Tông đã tiến hành cập nhật một số tính năng và nội dung mới vào các máy chủ theo lộ trình đã công bố. Chư vị có thể tham khảo thêm thông tin tại đây!</p>
                <a href="/tin-tuc/cap-nhat-tinh-nang.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/s6-lien-dau-t5-song-dau-tu-do.html" target="_blank" title="S6 - LIÊN ĐẤU T5: SONG ĐẤU TỰ DO">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/banner_liendau_s6_287.png" alt="S6 - LIÊN ĐẤU T5: SONG ĐẤU TỰ DO" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/s6-lien-dau-t5-song-dau-tu-do.html" target="_blank" alt="S6 - LIÊN ĐẤU T5: SONG ĐẤU TỰ DO">
                <h3 title="S6 - LIÊN ĐẤU T5: SONG ĐẤU TỰ DO">S6 - LIÊN ĐẤU T5: SONG ĐẤU TỰ DO</h3>
                </a>
                <span class="time">05/05/2023</span>
                <p class="desc">Tính năng được mong chờ và diễn ra mỗi tháng sẽ là nơi tỉ thí võ công giữa các cao thủ. Cùng với những phần quà Exp và điểm Vinh Dự dùng để đổi các vật phẩm quý. Hãy đăng ký chiến đội ngay...</p>
                <a href="/tin-tuc/s6-lien-dau-t5-song-dau-tu-do.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/chuoi-su-kien-mung-dai-le-30-4-2023.html" target="_blank" title="CHUỖI SỰ KIỆN MỪNG ĐẠI LỄ 30/4">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/3042023_287x184.jpg" alt="CHUỖI SỰ KIỆN MỪNG ĐẠI LỄ 30/4" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/chuoi-su-kien-mung-dai-le-30-4-2023.html" target="_blank" alt="CHUỖI SỰ KIỆN MỪNG ĐẠI LỄ 30/4">
                <h3 title="CHUỖI SỰ KIỆN MỪNG ĐẠI LỄ 30/4">CHUỖI SỰ KIỆN MỪNG ĐẠI LỄ 30/4</h3>
                </a>
                <span class="time">04/05/2023</span>
                <p class="desc">Hãy cùng Võ Lâm Chính Tông hướng tới đại lễ 30/4, mừng ngày thống nhất đất nước! Với chuỗi 8 hoạt động diễn ra cùng lúc, sẽ mang đến cho các huynh đệ những trải nghiệm và nhiều phần thưởng...</p>
                <a href="/tin-tuc/chuoi-su-kien-mung-dai-le-30-4-2023.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/phong-lang-do.html" target="_blank" title="S6 - PHONG LĂNG ĐỘ">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/T%C3%ADnh-N%C4%83ng.png" alt="S6 - PHONG LĂNG ĐỘ" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/phong-lang-do.html" target="_blank" alt="S6 - PHONG LĂNG ĐỘ">
                <h3 title="S6 - PHONG LĂNG ĐỘ">S6 - PHONG LĂNG ĐỘ</h3>
                </a>
                <span class="time">27/04/2023</span>
                <p class="desc">Phong Lăng Độ từ thuở hồng hoang khai mở đã được tương truyền là nơi đi dễ khó về, kẻ thủ ác cũng như thủy tặc giả danh rất nhiều. Hãy “cẩn thận củi lửa” khi tham gia tính năng Phong Lăng...</p>
                <a href="/tin-tuc/phong-lang-do.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/s6-su-kien-mung-dai-le-30-4.html" target="_blank" title="S6 - SỰ KIỆN MỪNG ĐẠI LỄ 30/4">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/3042023_S6_287x184.jpg" alt="S6 - SỰ KIỆN MỪNG ĐẠI LỄ 30/4" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/s6-su-kien-mung-dai-le-30-4.html" target="_blank" alt="S6 - SỰ KIỆN MỪNG ĐẠI LỄ 30/4">
                <h3 title="S6 - SỰ KIỆN MỪNG ĐẠI LỄ 30/4">S6 - SỰ KIỆN MỪNG ĐẠI LỄ 30/4</h3>
                </a>
                <span class="time">25/04/2023</span>
                <p class="desc">Hãy cùng Võ Lâm Chính Tông hướng tới đại lễ 30/4, mừng ngày thống nhất đất nước! Với chuỗi 8 hoạt động diễn ra cùng lúc, sẽ mang đến cho các huynh đệ những trải nghiệm và nhiều phần thưởng...</p>
                <a href="/tin-tuc/s6-su-kien-mung-dai-le-30-4.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/s135-hoat-dong-4-5-6-7-8.html" target="_blank" title="S135 - HOẠT ĐỘNG 4 5 6 7 8">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/3042023_S135_HD45678_287x184.jpg" alt="S135 - HOẠT ĐỘNG 4 5 6 7 8" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/s135-hoat-dong-4-5-6-7-8.html" target="_blank" alt="S135 - HOẠT ĐỘNG 4 5 6 7 8">
                <h3 title="S135 - HOẠT ĐỘNG 4 5 6 7 8">S135 - HOẠT ĐỘNG 4 5 6 7 8</h3>
                </a>
                <span class="time">25/04/2023</span>
                <p class="desc">Hãy cùng Võ Lâm Chính Tông hướng tới đại lễ 30/4, mừng ngày thống nhất đất nước! Với chuỗi 8 hoạt động diễn ra cùng lúc, sẽ mang đến cho các huynh đệ những trải nghiệm và nhiều phần thưởng...</p>
                <a href="/tin-tuc/s135-hoat-dong-4-5-6-7-8.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/s5-huan-chuong-anh-hung.html" target="_blank" title="S5 - HUÂN CHƯƠNG ANH HÙNG">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/3042023_S5_HD3_287x184.jpg" alt="S5 - HUÂN CHƯƠNG ANH HÙNG" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/s5-huan-chuong-anh-hung.html" target="_blank" alt="S5 - HUÂN CHƯƠNG ANH HÙNG">
                <h3 title="S5 - HUÂN CHƯƠNG ANH HÙNG">S5 - HUÂN CHƯƠNG ANH HÙNG</h3>
                </a>
                <span class="time">25/04/2023</span>
                <p class="desc">Hãy cùng Võ Lâm Chính Tông hướng tới đại lễ 30/4, mừng ngày thống nhất đất nước! Với chuỗi 8 hoạt động diễn ra cùng lúc, sẽ mang đến cho các huynh đệ những trải nghiệm và nhiều phần thưởng...</p>
                <a href="/tin-tuc/s5-huan-chuong-anh-hung.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/s1s3-huan-chuong-anh-hung.html" target="_blank" title="S1S3 - HUÂN CHƯƠNG ANH HÙNG">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/3042023_S13_HD3_287x184.jpg" alt="S1S3 - HUÂN CHƯƠNG ANH HÙNG" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/s1s3-huan-chuong-anh-hung.html" target="_blank" alt="S1S3 - HUÂN CHƯƠNG ANH HÙNG">
                <h3 title="S1S3 - HUÂN CHƯƠNG ANH HÙNG">S1S3 - HUÂN CHƯƠNG ANH HÙNG</h3>
                </a>
                <span class="time">25/04/2023</span>
                <p class="desc">Hãy cùng Võ Lâm Chính Tông hướng tới đại lễ 30/4, mừng ngày thống nhất đất nước! Với chuỗi 8 hoạt động diễn ra cùng lúc, sẽ mang đến cho các huynh đệ những trải nghiệm và nhiều phần thưởng...</p>
                <a href="/tin-tuc/s1s3-huan-chuong-anh-hung.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/s5-sao-vang-vinh-quang.html" target="_blank" title="S5 - SAO VÀNG VINH QUANG">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/3042023_S5_HD2_287x184.jpg" alt="S5 - SAO VÀNG VINH QUANG" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/s5-sao-vang-vinh-quang.html" target="_blank" alt="S5 - SAO VÀNG VINH QUANG">
                <h3 title="S5 - SAO VÀNG VINH QUANG">S5 - SAO VÀNG VINH QUANG</h3>
                </a>
                <span class="time">25/04/2023</span>
                <p class="desc">Hãy cùng Võ Lâm Chính Tông hướng tới đại lễ 30/4, mừng ngày thống nhất đất nước! Với chuỗi 8 hoạt động diễn ra cùng lúc, sẽ mang đến cho các huynh đệ những trải nghiệm và nhiều phần thưởng...</p>
                <a href="/tin-tuc/s5-sao-vang-vinh-quang.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/s3-sao-vang-vinh-quang.html" target="_blank" title="S3 - SAO VÀNG VINH QUANG">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/3042023_S3_HD2_287x184.png" alt="S3 - SAO VÀNG VINH QUANG" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/s3-sao-vang-vinh-quang.html" target="_blank" alt="S3 - SAO VÀNG VINH QUANG">
                <h3 title="S3 - SAO VÀNG VINH QUANG">S3 - SAO VÀNG VINH QUANG</h3>
                </a>
                <span class="time">25/04/2023</span>
                <p class="desc">Hãy cùng Võ Lâm Chính Tông hướng tới đại lễ 30/4, mừng ngày thống nhất đất nước! Với chuỗi 8 hoạt động diễn ra cùng lúc, sẽ mang đến cho các huynh đệ những trải nghiệm và nhiều phần thưởng...</p>
                <a href="/tin-tuc/s3-sao-vang-vinh-quang.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/s1-sao-vang-vinh-quang.html" target="_blank" title="S1 - SAO VÀNG VINH QUANG">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/3042023_S1_HD2_287x184.png" alt="S1 - SAO VÀNG VINH QUANG" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/s1-sao-vang-vinh-quang.html" target="_blank" alt="S1 - SAO VÀNG VINH QUANG">
                <h3 title="S1 - SAO VÀNG VINH QUANG">S1 - SAO VÀNG VINH QUANG</h3>
                </a>
                <span class="time">25/04/2023</span>
                <p class="desc">Hãy cùng Võ Lâm Chính Tông hướng tới đại lễ 30/4, mừng ngày thống nhất đất nước! Với chuỗi 8 hoạt động diễn ra cùng lúc, sẽ mang đến cho các huynh đệ những trải nghiệm và nhiều phần thưởng...</p>
                <a href="/tin-tuc/s1-sao-vang-vinh-quang.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/s5-vinh-danh-chien-si.html" target="_blank" title="S5 - VINH DANH CHIẾN SĨ">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/3042023_S5_HD1_287x184.jpg" alt="S5 - VINH DANH CHIẾN SĨ" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/s5-vinh-danh-chien-si.html" target="_blank" alt="S5 - VINH DANH CHIẾN SĨ">
                <h3 title="S5 - VINH DANH CHIẾN SĨ">S5 - VINH DANH CHIẾN SĨ</h3>
                </a>
                <span class="time">25/04/2023</span>
                <p class="desc">Hãy cùng Võ Lâm Chính Tông hướng tới đại lễ 30/4, mừng ngày thống nhất đất nước! Với chuỗi 8 hoạt động diễn ra cùng lúc, sẽ mang đến cho các huynh đệ những trải nghiệm và nhiều phần thưởng...</p>
                <a href="/tin-tuc/s5-vinh-danh-chien-si.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/s3-vinh-danh-chien-si.html" target="_blank" title="S3 - VINH DANH CHIẾN SĨ">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/3042023_S3_HD1_287x184.jpg" alt="S3 - VINH DANH CHIẾN SĨ" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/s3-vinh-danh-chien-si.html" target="_blank" alt="S3 - VINH DANH CHIẾN SĨ">
                <h3 title="S3 - VINH DANH CHIẾN SĨ">S3 - VINH DANH CHIẾN SĨ</h3>
                </a>
                <span class="time">25/04/2023</span>
                <p class="desc">Hãy cùng Võ Lâm Chính Tông hướng tới đại lễ 30/4, mừng ngày thống nhất đất nước! Với chuỗi 8 hoạt động diễn ra cùng lúc, sẽ mang đến cho các huynh đệ những trải nghiệm và nhiều phần thưởng...</p>
                <a href="/tin-tuc/s3-vinh-danh-chien-si.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
            <div class="item ">
            <div class="cover">
                <a href="/tin-tuc/s1-vinh-danh-chien-si.html" target="_blank" title="S1 - VINH DANH CHIẾN SĨ">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/3042023_S1_HD1_287x184.jpg" alt="S1 - VINH DANH CHIẾN SĨ" onError="this.src='//volamchinhtong.com/st/mainsite/imgs/no-image-2.jpg'">
                </a>
            </div>
            <div class="detail">
                <a href="/tin-tuc/s1-vinh-danh-chien-si.html" target="_blank" alt="S1 - VINH DANH CHIẾN SĨ">
                <h3 title="S1 - VINH DANH CHIẾN SĨ">S1 - VINH DANH CHIẾN SĨ</h3>
                </a>
                <span class="time">25/04/2023</span>
                <p class="desc">Hãy cùng Võ Lâm Chính Tông hướng tới đại lễ 30/4, mừng ngày thống nhất đất nước! Với chuỗi 8 hoạt động diễn ra cùng lúc, sẽ mang đến cho các huynh đệ những trải nghiệm và nhiều phần thưởng...</p>
                <a href="/tin-tuc/s1-vinh-danh-chien-si.html" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="support">
        <div class="llllll">
        <!-- <div class="block-support"><h3>Hỗ trợ</h3><div class="info-support"><p>Hotline</p><p class="fone-number"><a href="tel:0842665666">0842.665.666</a></p><p class="border-bottom">(Cước phí: 2000 VND/phút)</p><p>Trung tâm hỗ trợ</p></div></div> -->
        <div class="block-event">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/Untitled-2.png" alt="Bảo trì định kỳ">
        </div>
        <div class="block-event">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/b%E1%BA%A3o-tr%C3%AC03.png" alt="Bảo trì định kỳ">
        </div>
        <div class="block-video">
            <a href="/tin-tuc/cap-nhat-tinh-nang.html">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/updated1.png" alt="Trailer">
            </a>
        </div>
        </div>
        <div class="rrrrrr">
        <div class="block-social">
            <h3>Facebook</h3>
            <div class="social">
            <div class="fb-page" data-href="https://www.facebook.com/volamchinhtong" data-tabs="timeline" data-width="328" data-height="457" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                <blockquote cite="https://www.facebook.com/volamchinhtong" class="fb-xfbml-parse-ignore">
                <a href="https://www.facebook.com/volamchinhtong">Võ Lâm Chính Tông</a>
                </blockquote>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="content-right">
    <div class="inner">
        <a href="/download" class="download"></a>
        <a href="tel:0842665666" class="hotline"></a>
        <a href="https://volamchinhtong.com/tin-tuc/trung-gian-giao-dich.html" class="trade"></a>
        <a href="https://www.facebook.com/volamchinhtong" class="fanpage" target="_blank"></a>
        <a href="https://www.facebook.com/groups/volamchinhtong2005" class="group" target="_blank"></a>
        <a href="#" class="totop" id="totop"></a>
    </div>
    </div>
</div>

<?php 
    get_footer(); 
?>
