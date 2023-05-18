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
  $s=get_search_query();
  $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
  $query = new WP_Query(
    array(
		's' =>$s
    )
  );
?>

    <?php require_once( get_stylesheet_directory() . '/module/left.php' ); ?>
    <div class="content-center">
    <div class="detail-content">
        <div class="head">
          <h3>Kết Quả Tìm Kiếm "<?php echo get_search_query(); ?>" </h3>
          <p class="breadcrums">
            <a href="/">Trang chủ</a> / <span>Kết Quả Tìm Kiếm <?php echo get_search_query(); ?></span>
          </p>
        </div>
        <div class="body">
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
          </div>
          <div class="items">
          <?php
            while ( $query->have_posts() ) : $query->the_post() ; ?>
               <div class="item">
                <div class="cover">
                  <a href="<?php the_permalink() ?>" target="_self">
                    <img src="<?php the_post_thumbnail_url('NEWS-THUMB-SMAIL') ?>" alt="<?php the_title() ?>">
                  </a>
                </div>
                <div class="detail">
                  <h3>
                    <a href="<?php the_permalink() ?>" target="_self"><?php the_title() ?></a>
                  </h3>
                  <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                </div>
              </div>
          <?php    
            endwhile;
            wp_reset_query();
          ?>
          </div>
          <div class="paging">
            <div class="paging-inner">
            <?php
                // $GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;
                the_posts_pagination( array(
                  'prev_text' => __( '«', 'textdomain' ),
                  'next_text' => __( '»', 'textdomain' ),
                ) );
            ?>
            </div>
          </div>
        </div>
        </div>
    </div>
    <?php require_once( get_stylesheet_directory() . '/module/right.php' ); ?>
<?php
    get_footer();
?>
