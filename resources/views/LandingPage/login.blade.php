  @extends('LandingPage.layouts.login_layout')
  @extends('LandingPage.modals.signin_as')
  @section('title', 'Login Page')
  @include('LandingPage.modals.regfailsuccessCSS')

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
      .logo-container img {
          max-width: 300px; /* Adjust the size as needed */
          height: auto; /* Maintain aspect ratio */
          margin-bottom: 15px;
      }
      .logo-container {
          display: flex;
          justify-content: center;
          align-items: center;
          padding: 10px; /* Adjust as needed */
      }
      .page-header-image {
          position: relative;
          width: 100%;
          height: 10vh; /* Adjust as needed */
          background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../assets/img/login.jpg');
          background-size: cover;
          background-position: center;
          display: flex;
          justify-content: center;
          align-items: center;
          color: #fff; /* Ensure text is readable over the darker background */
          text-align: center;
          padding: 15px;
      }
      .page-header-image::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black overlay */
          z-index: 1;
      }
      ::placeholder {
          color: white !important;
          opacity: 0.2; /* Firefox */
      }

      :-ms-input-placeholder {
          color: white !important;
      }

      ::-ms-input-placeholder {
          color: white !important;
      }
  </style>

  <div class="page-header clear-filter" >
      <div class="page-header-image" style="background-image:url(../assets/img/login.jpg)"></div>
      <div class="content">
        <div class="container">
          <div class="col-md-4 ml-auto mr-auto">
            <div class="card card-login card-plain">
            <form action="{{route('login.post')}}" method="POST">
              @csrf
                <div class="card-header text-center">
                  <div class="logo-container">
                    <img src="../assets/img/now-logo.png" alt="">
                  </div>
                </div>
                <div class="card-body">
      <div class="input-group no-border input-lg">
          <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required style="color: white;" />
      </div>
      <div class="input-group no-border input-lg">
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required style="color: white;" />
      </div>
  </div>

                <div class="card-footer text-center">
                  <input type="submit" class="btn btn-primary btn-round btn-lg btn-block" value="Login">
                  <div class="pull-right">
                    <h6>
                      <br>
                      <a style = "color: white;" type="button" data-bs-toggle="modal" data-bs-target="#signin_role">Create Account</a>
                    </h6>
                  </div>
                </form>
                @if (Session::has('error'))
                <script>
                  swal("Login Failed!", "{{Session::get('error')}}", "warning")                 
              </script>
          @endif
        </div>
      </div>
      <center>
    <a href="javascript:void(0)" onclick="openModal()">Forgot Password?</a>
</center>
          </div>
        </div>
      </div>
      @include('LandingPage.modals.forgot_pass')

      <footer class="footer">
        <div class=" container ">
          <nav>
          <div class="copyright" id="copyright">
            &copy;
            <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, All right reserved. Project by
            <a>Quadra Cintech</a>.
          </div>
        </div>
      </footer>
    </div>

    <script>
function openModal() {
    document.getElementById('emailModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function validateEmail() {
    var email = document.getElementById('email').value;

    fetch('/send-verification-code', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal('emailModal');
            document.getElementById('codeModal').style.display = 'block';
        } else {
            swal("Error", data.error, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        swal("Error", "An error occurred. Please try again.", "error");
    });
}

function validateCode() {
    var code = document.getElementById('code').value;

    fetch('/verify-code', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ code: code })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal('codeModal');
            document.getElementById('passwordModal').style.display = 'block';
        } else {
            swal("Error", data.error, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        swal("Error", "An error occurred. Please try again.", "error");
    });
}

function saveChanges() {
    var newPassword = document.getElementById('new_password').value;
    var confirmPassword = document.getElementById('confirm_Password').value;

    if (newPassword !== confirmPassword) {
        swal("Error", "Passwords do not match.", "error");
        return;
    }

    fetch('/reset-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ new_password: newPassword, new_password_confirmation: confirmPassword })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                throw new Error(data.error || 'Unknown error');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            swal("Success", "Password updated successfully.", "success");
            closeModal('passwordModal');
        } else {
            swal("Error", data.error, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        swal("Error", "An error occurred. Please try again.", "error");
    });
}

</script>
    