<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package volam
 */

?>
</div>
  <div class="footer">
    <div class="footer-inner">
      <div class="logo">
        <a href="/">
          <img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/logo.jpg" style="width: 176px; height: 150px;"  alt="volam">
        </a>
      </div>
      <div class="info">
        <p class="copyright">Bản quyền trò chơi thuộc công ty Kingsoft</p>
        <p>Địa chỉ : Trụ sở Bang Hội La Sát tại 48 Bùi Thị Xuân, Phường 2, Tân Bình, Sài Gòn</p>
        <p>Hotline: 0898 890 474</p>
        <ul>
          <li>
            <a href="/privacy">Quyền riêng tư</a>
          </li>
          <li>
            <a href="/terms">Điều khoản</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
</div>
<?php wp_footer(); ?>
<script >
    // Variables to store alert elements
    const elStatus = document.getElementById('alert-danger');
    const elSuccess = document.getElementById('alert-success');

    // Function to save token to local storage
    function saveTokenToLocalStorage(token) {
        if (token) {
            localStorage.removeItem('token'); // Remove the existing token
            localStorage.setItem('token', token); // Set the new token
        }
    }

    // Function to retrieve token from local storage
    function getTokenFromLocalStorage() {
        return localStorage.getItem('token');
    }

    // Function to make API call to retrieve user info using the saved token
    function getUserInfo() {
        // Get the token from local storage
        const token = getTokenFromLocalStorage();

        // Make the API call with the token
        fetch('http://volamnhatpham.com/api/me', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => response.json())
            .then(data => {
                // Process the API response
                console.log(data);
            })
            .catch(error => {
                // Handle any errors
                console.error(error);
            });
    }

    // Function to make API call to check if the user exists using the saved token
    function getIsUser() {
        return new Promise((resolve, reject) => {
            // Get the token from local storage
            const token = getTokenFromLocalStorage();

            // Make the API call with the token
            fetch('http://volamnhatpham.com/api/me', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => response.json())
                .then(data => {
                    resolve(true); // User exists
                })
                .catch(error => {
                    resolve(false); // User does not exist or an error occurred
                });
        });
    }

    // Function to display error messages
    function displayErrorMessage(errors) {
      const alertDanger = document.getElementById('alert-danger');
      alertDanger.innerHTML = ''; // Clear previous error messages

      if (errors && typeof errors === 'object' && errors.hasOwnProperty('error')) {
        const errorObject = errors.error;
        for (const key in errorObject) {
          if (errorObject.hasOwnProperty(key)) {
            const errorMessages = errorObject[key];
            errorMessages.forEach(errorMessage => {
              const errorElement = document.createElement('p');
              errorElement.textContent = `${key}: ${errorMessage}`;
              alertDanger.appendChild(errorElement);
            });
          }
        }
      } else if (typeof errors === 'string') {
        const errorElement = document.createElement('p');
        errorElement.textContent = errors;
        alertDanger.appendChild(errorElement);
      } else if (typeof errors === 'object') {
        for (const key in errors) {
          if (errors.hasOwnProperty(key)) {
            const errorMessages = errors[key];
            errorMessages.forEach(errorMessage => {
              const errorElement = document.createElement('p');
              errorElement.textContent = `${key}: ${errorMessage}`;
              alertDanger.appendChild(errorElement);
            });
          }
        }
      }

      alertDanger.style.display = 'block';
    }


    // Function to clear token from local storage
    function clearTokenFromLocalStorage() {
        localStorage.removeItem('token');
        window.location.href = '/dang-nhap';
    }
    
    // Event listener for reset pass form submission
    function handleSubmitRestPassword(event) {
      event.preventDefault(); // Prevent form submission
      // Get the form data
      const password1 = document.getElementById('password1').value;
      const password1_confirmation = document.getElementById('password1_confirmation').value;
      const password2 = document.getElementById('password2').value;
      // Get the token from local storage
      const token = getTokenFromLocalStorage();
      // Make the API call to change the password
      fetch('http://volamnhatpham.com/api/change-password1', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          password1: password1,
          password1_confirmation: password1_confirmation,
          password2: password2,
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.access_token) {
            console.log('Đổi mật khẩu thành công');
            elSuccess.innerHTML += 'Đổi mật khẩu thành công';
            elSuccess.style = 'block';
            clearTokenFromLocalStorage();
            window.location.href = '/dang-nhap';
          } else {
            console.error('Failed to change password');
            displayErrorMessage(data.error);
          }
        })
        .catch(error => {
          console.error(error);
          console.error('Failed to change password');
          displayErrorMessage(data.error);
        });
    }

    // Event listener for login form submission
    function handleSubmitLogin(event) {
      event.preventDefault(); // Prevent form submission

      // Get the form data
      const login_id = document.getElementById('uname-login').value;
      const password = document.getElementById('uname-pass').value;

      // Make the API call to authenticate the user
      fetch('http://volamnhatpham.com/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          login_id: login_id,
          password1: password,
        })
      })
        .then(response => response.json())
        .then(data => {
          console.log(data.token);
          // Check if login was successful
          if (data.access_token && data.token) {
            const token = data.token;
            console.log('login true');
            saveTokenToLocalStorage(token); // Save the token to local storage
            elSuccess.innerHTML += 'Đăng nhập thành công';
            elSuccess.style = 'block';
            window.location.href = '/thong-tin-ca-nhan';
          } else {
            // Handle login error
            console.error('Login failed');
            displayErrorMessage(data.error);
          }
        })
        .catch(error => {
          // Handle any errors
          console.error(error);
          elStatus.innerHTML += 'LỖI: Sai tài khoản hoặc mật khẩu. Vui lòng thử lại và lưu ý phân biệt chữ "HOA" chữ "thường"!';
          elStatus.style = 'block';
        });
    }

    // Event listener for registration form submission
    function handleSubmitRegister(event) {
      event.preventDefault(); // Prevent form submission

      // Get the form data
      const name = document.getElementById('name').value;
      const loginId = document.getElementById('login_id').value;
      const password1 = document.getElementById('password1').value;
      const password1Confirmation = document.getElementById('password1_confirmation').value;
      const password2 = document.getElementById('password2').value;
      const password2Confirmation = document.getElementById('password2_confirmation').value;

      // Make the API call to register the user
      fetch('http://volamnhatpham.com/api/register', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify({
              name: name,
              login_id: loginId,
              password1: password1,
              password1_confirmation: password1Confirmation,
              password2: password2,
              password2_confirmation: password2Confirmation
          })
      })
      .then(response => response.json())
      .then(data => {
          console.log(data);
          // Check if registration was successful
          if (data.token && data.token_type) {
            const token = data.token;
            console.log('login true');
            saveTokenToLocalStorage(token); // Save the token to local storage
            elSuccess.innerHTML += 'Đăng ký thành công';
            elSuccess.style = 'block';
            window.location.href = '/thong-tin-ca-nhan';
          }
          else {
              // Handle registration error
              console.error('Registration failed');
              displayErrorMessage(data.error);
          }
      })
      .catch(error => {
          // Handle any errors
          console.error(error);
          const errorMessageElement = document.getElementById('alert-danger');
          errorMessageElement.innerHTML = 'LỖI: Đã xảy ra lỗi khi gửi yêu cầu đăng ký.';
          errorMessageElement.style.display = 'block';
      });
    }

</script>
<?php if(is_page('dang-nhap')) : ?>
  <script>
   document.addEventListener("DOMContentLoaded", function(event) {
      getIsUser()
        .then(result => {
          if (result === true) {
            console.log(true);
            elSuccess.innerHTML += 'Đăng nhập thành công';
            elSuccess.style = "block";
            window.location.href = '/thong-tin-ca-nhan';
          }
        })
        .catch(error => {
          console.log('vui lòng đăng nhập');
          window.location.href = '/dang-nhap';
        });
    });
  </script>
<?php endif; ?>
<?php if(is_page('thong-tin-ca-nhan')) : ?>
  <script>
      document.addEventListener("DOMContentLoaded", function(event) {
        getUserInfo();
      });
    // Function to make API call to retrieve user info using the saved token
    function getUserInfo() {
      // Get the token from local storage
      const token = getTokenFromLocalStorage();

      // Make the API call with the token
      fetch('http://volamnhatpham.com/api/me', {
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
        .then(response => response.json())
        .then(data => {
          // Process the API response and build the table HTML
          const userInfo = data.user;
          const tableBody = document.querySelector('.user-info-table tbody');

          // Clear existing table rows
          tableBody.innerHTML = '';

          // Create table rows dynamically
          Object.keys(userInfo).forEach(key => {
            const row = document.createElement('tr');
            const keyCell = document.createElement('td');
            const valueCell = document.createElement('td');

            keyCell.textContent = key;
            valueCell.textContent = userInfo[key];

            row.appendChild(keyCell);
            row.appendChild(valueCell);

            tableBody.appendChild(row);
          });
        })
        .catch(error => {
          // Handle any errors
          console.error(error);
          console.log('vui lòng đăng nhập');
          window.location.href = '/dang-nhap';
        });
    }
  </script>
<?php endif; ?>  
<!-- Messenger Plugin chat Code -->
<div id="fb-root"></div>
<!-- Your Plugin chat code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>
<script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "114690851619456");
  chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v17.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
</body>
</html>
