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
            <div id="iframe-menu-left">
            <div class="menu-left">
                <ul>
                <li>
                    <a target="_top" href="https://volamnhatpham.com/dang-nhap">Đăng nhập</a>
                </li>
                <li>
                    <a target="_top" href="https://volamnhatpham.com/dang-ky">Đăng ký</a>
                </li>
                <li>
                    <a target="_top" href="https://volamnhatpham.com/thong-tin-ca-nhan">Quản lý tài khoản</a>
                </li>
                <li>
                    <a target="_top" href="https://volamnhatpham.com/quen-otp">Quên OTP</a>
                </li>
                </ul>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="content-center">
        <div class="iframe-id">
        <div class="wrap-iframe">
            <div id="iframe-id">
            <div class="form form-min pd-b-50">
                <form method="post" id="loginForm">
                <input type="hidden" name="login_id" value="wordpress">
                <h2>Đăng nhập</h2>
                <div class="hr mr-b-30"></div>
                <div class="form-group">
                    <label for="uname-login">Tài khoản *</label>
                    <input class="form-control" id="uname-login" type="email" name="email" value="" placeholder="Độ dài từ 6 đến 24 ký tự. Sử dụng các ký tự: a-z, 0-9">
                </div>
                <div class="form-group">
                    <label for="uname-pass">Mật khẩu *</label>
                    <input class="form-control" id="uname-pass" type="password" name="password1" value="" placeholder="Độ dài từ 6 đến 32 ký tự">
                </div>
                <div class="form-group">
                    <a class="forget-pass open-iframe" href="/quen-mat-khau-cap" target="_top">Quên mật khẩu?</a>
                    <a class="forget-otp pull-right" href="/quen-otp" target="_top">Quên OTP?</a>
                </div>
                <div class="form-group form-group-submit">
                    <button class="btn btn-primary" type="submit" name="submit" value="login">Đăng nhập</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div> 
    <script>
  document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    var email = document.getElementById('uname-login').value;
    var password = document.getElementById('uname-pass').value;

    var formData = {
      email: email,
      password1: password,
      login_id: 'wordpress'
    };

    // Make the login API call
    fetch('https://volamnhatpham.com/api/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(formData)
    })
      .then(function(response) {
        if (response.ok) {
          return response.json();
        } else {
          throw new Error('Login failed');
        }
      })
      .then(function(data) {
        var token = data.token; // Retrieve the token from the response

        // Make the "me" API call with the obtained token
        fetch('https://volamnhatpham.com/api/me', {
          method: 'GET',
          headers: {
            'Authorization': 'Bearer ' + token
          }
        })
          .then(function(response) {
            if (response.ok) {
              return response.json();
            } else {
              throw new Error('Failed to retrieve user information');
            }
          })
          .then(function(data) {
            // Handle the response from the "me" API call
            console.log('User information:', data);
          })
          .catch(function(error) {
            console.error(error);
          });
      })
      .catch(function(error) {
        console.error(error);
      });
  });
</script>

<?php
    get_footer();
?>