<div class="content-center">
  <div class="detail-content">
    <div class="head">
      <h3><?php the_title() ?></h3>
      <p class="time"><?php echo get_the_date("d/m/y");?></p>
    </div>
    <div class="body">
      <div class="content">
        <?php the_content() ?>
      </div>
      <div class="title title-0">BÀI LIÊN QUAN :</div>
      <?php 
        $related_args = array(
            'post_type' => 'post',
            'posts_per_page' => 5,
            'post_status' => 'publish',
            'post__not_in' => array( get_the_ID() ),
            'orderby' => 'rand',
        );
        $related = new WP_Query( $related_args );
        if( $related->have_posts() ) :
        while( $related->have_posts() ): $related->the_post(); 
      ?>
        <div class="title">
            <a class="tit" href="<?php the_permalink() ?>" title="<?php the_title() ?>" target="_self" rel=""><?php the_title() ?></a>
        </div>
      <?php
        endwhile;
        endif;
        wp_reset_postdata();
      ?>
    </div>
  </div>
</div> <?php require_once( get_stylesheet_directory() . '/module/right.php' ); ?>