elStatus = document.getElementById('alert-danger');
elSuccess = document.getElementById('alert-success');
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

// Function to make API call using the saved token
function makeAPICallWithToken() {
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

// Event listener for login form submission
document.getElementById('loginForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent form submission

  // Get the form data
  const email = document.getElementById('uname-login').value;
  const password = document.getElementById('uname-pass').value;

  // Make the API call to authenticate the user
  fetch('http://volamnhatpham.com/api/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      email: email,
      password1: password,
      login_id: 'wordpress'
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
        elSuccess.style = "block";
        window.location.href = '/thong-tin-ca-nhan';
        makeAPICallWithToken(); // Call another API using the saved token
      } else {
        // Handle login error
        console.error('Login failed');
        elStatus.innerHTML += 'LỖI: Vui lòng Kiểm tra lại username hoặc mật khẩu.';
        elStatus.style = "block";
      }
    })
    .catch(error => {
      // Handle any errors
      console.error(error);
      elStatus.innerHTML += 'LỖI: Vui lòng Kiểm tra lại username hoặc mật khẩu.';
      elStatus.style = "block";
    });
});