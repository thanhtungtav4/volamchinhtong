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
<div class="content-center">
  <div class="download-main">
    <a class="tit" href="#">Hướng dẫn tải game</a>
    <div class="clearfix"></div>
    <div class="download-option">
      <div class="package package-full">
        <div class="step step-start" style="height: 71.8229px;">
          <a target="_blank" href="#" class="download-full" onclick="downloadFull()">Bản đầy đủ (2.5G)</a>
        </div>
        <div class="step" style="height: 268.164px;">
          <div class="text"> Bước 1: <span class="highlight">Tải Game</span>
          </div>
          <div class="text-center">
            <a target="_blank" href="#" class="download-full download-image" onclick="downloadFull()">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/btn-download-transparent.png" alt="Download">
            </a>
          </div>
          <span class="highlight block text-center">&nbsp;</span>
        </div>
        <div class="step step-2" style="height: 45px;">
          <div class="text">
            Bước 2: <span class="highlight">Chạy file vừa tải về</span>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="step step-2" style="height: 65px;">
          <div class="text"> Bước 3: <span class="highlight">Nhấn [Install]</span>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="step step-2" style="height: 45px;">
          <div class="text"> Bước 4: <span class="highlight">Vào game</span>
            <br>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="step step-2 step-noborder" style="height: 45px;">
          <div class="text"> &nbsp; </div>
        </div>
      </div>
      <div class="package package-mini">
        <div class="step step-start">
          <a target="_blank" href="#" class="download-mini" onclick="downloadMini()">Bản patch (40MB)</a>
        </div>
        <div class="step">
          <div class="text">
             Bước 1: <span class="highlight">Tải patch nếu máy đã có game VLTK</span>
          </div>
          <div class="text-center">
            <a target="_blank" href="#" class="download-mini download-image" onclick="downloadMini()">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/btn-download-transparent.png" alt="Download">
            </a>
          </div>
          <!-- <span class="highlight block text-center">( Đã có source game Võ Lâm )</span> -->
        </div>
        <div class="step step-2">
          <div class="text">
            <!-- Bước 2: <span class="highlight">Giải nén (mật khẩu giải nén: 123456)</span> --> Bước 2: <span class="highlight">Chạy file vừa tải về</span>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="step step-2">
          <div class="text">
            <!-- Bước 3: <span class="highlight">Copy thư mục DATA của source game Võ Lâm có sẵn vào</span> --> Bước 3: <span class="highlight">Nhấn [Browse...] rồi chọn đến thư mục game Võ Lâm có sẵn trên máy</span>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="step step-2">
          <div class="text">
            <!-- Bước 4: <span class="highlight">Chạy file autoupdate.exe để cập nhật bản mới nhất</span> --> Bước 4: <span class="highlight">Nhấn [Install]</span>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="step step-2">
          <div class="text"> Bước 5: <span class="highlight">Vào game</span>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="step step-footer step-noborder">
      <ul class="info-news">
        <!-- <li><a href="#" target="_blank">Hướng dẫn chỉnh màn hình về 16 bit</a></li><li><a href="#" target="_blank">Hướng dẫn khắc phục việc không thể mở game</a></li> -->
        <li>
          <a href="https://volamnhatpham.com/tin-tuc/huong-dan-khac-phuc-loi.html" target="_blank">Hướng dẫn khắc phục một số lỗi thường gặp khi chạy game</a>
        </li>
        <li>
          <a href="https://www.messenger.com/t/volamnhatpham.com" target="_blank">Hỗ trợ khách hàng: Liên hệ Fanpage hoặc Hotline: 0842.665.666</a>
        </li>
      </ul>
    </div>
    <div class="border-footer block text-center"></div>
  </div>
</div>
<?php
    get_footer();
?>
