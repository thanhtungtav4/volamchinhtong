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
?>

    <?php require_once( get_stylesheet_directory() . '/module/left.php' ); ?>
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
        <form action="/" method="get" class="search-lite">
            <input type="text" name="s" id="search" placeholder="Nhập từ khóa tìm kiếm"   value="<?php the_search_query(); ?>" />
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
            <div class="item hot">
                <div class="cover">
                    <a href="<?php the_permalink()?>" target="_blank" title="<?php the_title()?>">
                    <img src="<?php the_post_thumbnail_url('NEWS-THUMB') ?>" alt="<?php the_title()?>">
                    </a>
                </div>
                <div class="detail">
                    <a href="<?php the_permalink()?>" target="_blank" alt="<?php the_title()?>">
                    <h3 title="<?php the_title()?>"><?php the_title()?></h3>
                    </a>
                    <span class="time"><?php echo get_the_date("d/m/y");?></span>
                    <p class="desc"><?php echo wp_trim_words(get_the_excerpt(), 40, '...'); ?></p>
                    <a href="<?php the_permalink()?>" target="_blank" class="viewmore">Xem thêm &raquo;</a>
                </div>
            </div>
            <?php
                endwhile;
                wp_reset_postdata();
            ?>
        <div class="list">
        <?php
            $argsNewsList = array(
                'post__in' => get_field('news_list'),
                'posts_per_page' => 10,
            );
            $queryList = new WP_Query( $argsNewsList );
            while ( $queryList->have_posts() ) : $queryList->the_post(); ?>
          <div class="item ">
            <div class="cover">
              <a href="<?php the_permalink()?>" target="_blank" title="<?php the_title()?>">
                <img src="<?php the_post_thumbnail_url('NEWS-THUMB-SMAIL') ?>" alt="<?php the_title()?>">
              </a>
            </div>
            <div class="detail">
              <a href="<?php the_permalink()?>" target="_blank" alt="<?php the_title()?>">
                <h3 title="<?php the_title()?>"><?php the_title()?></h3>
              </a>
              <span class="time"><?php echo get_the_date("d/m/y");?></span>
              <p class="desc"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
              <a href="<?php the_permalink()?>" target="_blank" class="viewmore">Xem thêm &raquo;</a>
            </div>
          </div>
        <?php
            endwhile;
            wp_reset_postdata();
        ?>
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
    <?php require_once( get_stylesheet_directory() . '/module/right.php' ); ?>
<?php
    get_footer();
?>
