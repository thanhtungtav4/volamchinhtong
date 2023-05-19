<?php 
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
                <a href="#" class="log  "></a>
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
            <div class="fb-group" data-href="https://www.facebook.com/groups/VoLamNhatPham" data-width="305" data-show-social-context="true" data-show-metadata="true">Nhóm Facebook Võ Lâm Chính Tông</div>
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