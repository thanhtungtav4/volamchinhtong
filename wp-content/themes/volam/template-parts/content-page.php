<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package volam
 */

?>
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
    </div>
  </div>
</div> <?php require_once( get_stylesheet_directory() . '/module/right.php' ); ?>