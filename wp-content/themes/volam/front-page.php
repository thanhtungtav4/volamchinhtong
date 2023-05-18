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
  $Carousel = get_field('carousel_home');
  $DayEvents = get_field('event_days', 'option');
  $Notifications = get_field('notification');
  $Wday = getdate()['wday'];
?>

    <div class="content-left">
    <div class="block-user-account">
        <a href="/download" class="download">
        <video width="310" height="160" preload loop muted autoplay poster>
            <source src="media/btn-download.mp4" type="video/mp4">
        </video>
        </a>
        <div class="clip">
        <img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/download.jpg" alt="Download client">
        </div>
        <div class="reglog">
        <a href="/dang-ky" class="reg " data-task="login"></a>
        </div>
        <a href="/#" class="user-account widget-login" data-task="login"></a>
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
                <?php if( have_rows('event_days', 'option')): ?>
                    <?php $ekey= 1 ; while ( have_rows('event_days', 'option') ) : the_row(); $ekey++ ;?>
                        <div class="day t<?php ($ekey != 8) ? print $ekey : print ' cn' ?>"  <?php ($ekey == $Wday) ? print 'style="display: block;"' : '';?>>
                            <div class="content">
                                <?php if( have_rows('events') ): ?>
                                    <?php while ( have_rows('events') ) : the_row();  ?>
                                    <div class="item">
                                        <div class="name"> <?php the_sub_field('name_event');?></div>
                                        <div class="time"> <?php the_sub_field('description_event');?></div>
                                    </div>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                                <p> &nbsp;</p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
    <div class="content-center">
    <?php if($Carousel) :?>
        <div class="slide">
            <div class="owl-carousel">
                <?php  foreach( $Carousel as $item ) : ?>
                    <div class="item">
                        <a href="<?php echo $item['url_carousel']; ?>" target="_blank">
                        <img loading="lazy" src="<?php echo $item['image_carousel']; ?>" alt="">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
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
        <?php
            $argsNews = array(
                'post__in' => get_field('news_hot'),
                'posts_per_page' => 1,
                'limit' => '1'
            );
            $queryHot = new WP_Query( $argsNews );
            while ( $queryHot->have_posts() ) : $queryHot->the_post(); ?>
        ?>
            <div class="item hot">
                <div class="cover">
                    <a href="<?php the_permalink()?>" target="_blank" title="<?php the_title()?>">
                    <img src="<?php the_post_thumbnail_url('NEWS-THUMB') ?>" alt="<?php the_title()?>">
                    </a>
                </div>
                <div class="detail">
                    <a href="<?php the_permalink()?>" target="_blank" alt="<?php //the_title()?>">
                    <h3 title="ĐUA TOP BANG HỘI - DÃ TẨU"><?php the_title()?></h3>
                    </a>
                    <span class="time"><?php echo get_the_date("d/m/y");?></span>
                    <p class="desc">Sự kiện Đua Top Bang Hội lần này sẽ chỉ tập trung vào hoạt động Dã Tẩu sẽ là một hoạt động thú vị. Ngoài Vượt Ải và Dã Tẩu thì sắp tới sẽ có đua top TK và PLD để hấp dẫn hơn</p>
                    <a href="<?php the_permalink()?>" target="_blank" class="viewmore">Xem thêm &raquo;</a>
                </div>
            </div>
            <?php
                endwhile;
                wp_reset_postdata();
            ?>
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
        </div>
      </div>
    </div>
    <div class="support">
        <div class="llllll">
            <?php if($Notifications) :?>
                <?php  foreach( $Notifications as $nitem ) : ?>
                    <div class="block-event">
                        <a href="<?php echo $nitem['notification_url']; ?>">
                            <img loading="lazy" src="<?php echo $nitem['notification_image']; ?>" alt="Trailer">
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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
<?php
    get_footer();
?>
