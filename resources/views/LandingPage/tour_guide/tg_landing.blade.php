<?php
    $user = Auth::guard('guide')->user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourist Guide Dashboard</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Cropper.js CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #ddd;
        }
        .navbar .navbar-brand {
            color: #000;
            font-weight: bold;
            font-size: 24px;
        }

        .sidebar-container {
            position: relative;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100%;
            background-color: #343a40;
            color: #ffffff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transform: translateX(0); /* Ensure the sidebar is visible on page load */
            transition: transform 0.3s ease-in-out;
            z-index: 1000; /* Ensure the sidebar is above other content */
        }

        .sidebar.active {
            transform: translateX(0);
        }

      
     

        #toggle-button i {
            font-size: 20px;
        }

        .sidebar .nav-link {
            color: #ffffff;
            margin: 10px 0;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s, color 0.3s;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #4fcf26;
            color: #ffffff;
        }

        .main-content {
            margin-left: 270px;
            padding: 40px;
            background-color: #f4f4f4;
            transition: margin-left 0.3s ease-in-out;
        }

        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .sign-out {
            padding: 1rem;
            text-align: center;
        }

        .sign-out button {
            width: 100%;
            padding: 0.5rem;
            border: none;
            background-color: rgba(152, 251, 152, 0.5); /* Light mint green with low opacity */
            color: #333;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-card {
            position: relative;
            background-color: #fff;
            border: 1px solid #e1e8ed;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: left;
        }

        .profile-card .header {
            position: relative;
            background-color: #4fcf26;
            height: 120px;
            border-radius: 6px 6px 0 0;
        }

        .profile-card .avatar-container {
            position: absolute;
            top: 80px;
            left: 20px;
            width: 100px;
            height: 100px;
            border: 4px solid #fff;
            border-radius: 50%;
            overflow: hidden;
        }

        .profile-card .avatar-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-card .profile-info {
            padding-left: 140px;
            padding-top: 20px;
        }

        .profile-card .profile-info h3 {
            margin: 0;
            color: #14171a;
            font-size: 20px; /* Reduced size */
        }

        .profile-card .profile-info p {
            margin: 5px 0;
            color: #657786;
            font-size: 14px;
        }

        .profile-card .profile-info .form-control {
            display: none;
            margin-bottom: 10px;
        }

        .profile-card .profile-info .editable {
            display: inline;
        }

        .profile-card .edit-button, .profile-card .save-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #4fcf26;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 20px;
            cursor: pointer;
        }

        .profile-card .edit-button:hover, .profile-card .save-button:hover {
            background-color: #45b31a;
        }

        .btn-view {
            background-color: #17a2b8;
            color: white;
            border: none; /* Optional: Remove border if desired */
        }

        .btn-view:hover {
            background-color: #138496; /* Darken on hover */
        }

        .btn-success {
            background-color: #4fcf26;
        }

        .profile-card .file-input {
            display: none;
        }

        /* Custom styles for modal */
        .modal-dialog-custom {
            max-width: 600px;
            margin: auto;
        }

        .modal-content-custom {
            padding: 20px;
            height: auto;
            overflow: visible;
        }

        .cropper-container {
            width: 100%;
            height: auto;
        }

        #image-to-crop {
            width: 100%;
            height: auto;
        }

        /* Additional styles for two-column layout */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .container-fluid {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .card-header {
            font-size: 18px; /* Adjusted size */
            font-weight: bold;
            margin-bottom: 15px;
        }

        .card-body {
            font-size: 14px;
            color: #657786;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                z-index: 1000; /* Ensure the sidebar is above other content */
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            #toggle-button {
                display: none; /* Adjust visibility as needed */
                position: fixed;
                top: 20px;
                left: 20px;
                background-color: green;
                color: white;
                border: none;
                padding: 0; /* Remove padding to ensure accurate height and width */
                cursor: pointer;
                border-radius: 5px;
                z-index: 1001; /* Ensure the button is above the sidebar */
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                width: 40px; /* Adjust width as needed */
                height: 40px; /* Ensure height is sufficient to contain bars */
            }

            .navbar-toggler-bar {
                display: block;
                width: 25px; /* Adjust bar width as needed */
                height: 3px; /* Adjust bar height as needed */
                background-color: white;
                border-radius: 3px;
                margin-left: 7px;
                margin-bottom: 4px;
                transition: background-color 0.3s ease; /* Optional: Transition effect */
            }

            /* Optional: Change color or style when the button is active */
            #toggle-button.active .navbar-toggler-bar {
                background-color: #ccc; /* Change color on active */
            }


           
            .profile-card .profile-info {
                padding-left: 0;
                padding-top: 60px;
                text-align: center;
            }

            .profile-card .avatar-container {
                left: 50%;
                transform: translateX(-50%);
                top: 20px;
            }

            .profile-card .edit-button, .profile-card .save-button {
                top: 10px;
                right: 10px;
            }
          
        }
    </style>
</head>
<body>
    @include('LandingPage.modals.pax_meminfo')

    <button id="toggle-button" aria-label="Menu">
        <span class="navbar-toggler-bar top-bar"></span>
        <span class="navbar-toggler-bar middle-bar"></span>
        <span class="navbar-toggler-bar bottom-bar"></span>
    </button>
    <div class="sidebar-container">
        
        <div class="sidebar">
            <h2 class="text-center"  style="margin-top: 5rem;">Guide Dashboard</h2>
            <nav class="nav flex-column">
                <a class="nav-link active menu-item" href="#" data-target="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a class="nav-link menu-item" href="#"data-target="#profile"><i class="fas fa-money-bill-wave"></i>Pending Hike Registration</a>
                <a class="nav-link menu-item" href="#" data-target="#clients"><i class="fas fa-user"></i> Hike Logs</a>
                <a class="nav-link menu-item" href="#" data-target="#ratings"><i class="fas fa-mobile-alt"></i> Communication</a>
                
                <a class="nav-link menu-item" href="#"><i class="fas fa-comments"></i> Messages</a>
                <div class="sign-out">
                    <button type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Sign-out
                    </button>
                </div>
            </nav>
        </div>
    </div>
    <div class="main-content"  style="margin-top: 3rem;">
        <div class="content" id="dashboard">
            <div class="container-fluid">
          
                        <div class="card profile-card">
                            <div class="header"></div>
                            <div class="avatar-container">
                                <img src="https://via.placeholder.com/150" alt="Profile Picture" id="profile-pic">
                                <div class="change-image" id="change-image-overlay">Change Image</div>
                            </div>
                            <input type="file" class="file-input" id="file-input" accept="image/*">
                            <div class="profile-info">
                                <h3 id="display-name" class="editable">{{ $user->first_name }} {{ $user->last_name }}</h3>
                                <input type="text" class="form-control" id="name-input" value="{{ $user->first_name }} {{ $user->last_name }}"><br>
                                <p id="display-email" class="editable">Email: {{ $user->email }}</p> 
                                <input type="email" class="form-control" id="email-input" value="{{ $user->email }}"><br>
                                <p id="display-contact_num" class="editable">Contact No: {{ $user->contact_num }}</p>
                                <input type="tel" class="form-control" id="contact_num-input" value="{{ $user->contact_num}}">
                                <p id="last-login">Last login: Aug 7, 2024 | Weds 2:10 PM (IST)</p>
                            </div>
                            <button class="edit-button" id="edit-profile-btn">Edit Profile</button>
                            <button class="save-button" id="save-profile-btn" style="display: none;">Save</button>
                        </div>
               
                        <div class="container mt-4">
                            <div class="row">
                                <!-- Transaction Payment History Card -->
                                <div class="col-md-6 mb-4">
                                    <div class="card transaction-history-card">
                                        <div class="card-header">
                                            Transaction Payment History
                                        </div>
                                        <div class="card-body">
                                            No Transaction History
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Recent Notifications Card -->
                                <div class="col-md-6 mb-4">
                                    <div class="card notification-drawer-card">
                                        <div class="card-header">
                                            Recent Notifications
                                        </div>
                                        <div class="card-body">
                                            No Notifications
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

               
                    <div class="card accounts-card">
                        @include('LandingPage.tour_guide.tg_profile')
                    </div>
                
            </div>
        </div>
        <div class="content" id="clients" style="display:none;">
            <div class="card accounts-card">
                @include('LandingPage.tour_guide.guide_client')
            </div>
        </div>
        <div class="content" id="ratings" style="display:none;">
            <div class="card accounts-card">
                @include('LandingPage.tour_guide.tg_rating')
            </div>
        </div>
        <div class="content" id="profile" style="display:none;">
                <div class="card accounts-card">
                    @include('LandingPage.tour_guide.pending_reg')
                </div>
        </div>
        <div class="content" id="hiking-records" style="display:none;">
            <div class="card hiking-records-card">
                <h3>Hiking Records</h3>
                <ul>
                    <li>
                        <span>Mountain Everest</span>
                        <span class="completed">Completed</span>
                    </li>
                    <li>
                        <span>Grand Canyon</span>
                        <span class="pending">Pending</span>
                    </li>
                    <li>
                        <span>Rocky Mountains</span>
                        <span class="completed">Completed</span>
                    </li>
                    <li>
                        <span>Appalachian Trail</span>
                        <span class="pending">Pending</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    @include('LandingPage.modals.crop_image')

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Cropper.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.getElementById('toggle-button');
            const sidebar = document.querySelector('.sidebar');

            function updateToggleButtonVisibility() {
                if (window.innerWidth >= 769) { // Only apply on larger screens
                    if (sidebar.classList.contains('active')) {
                        toggleButton.style.display = 'none';
                    } else {
                        toggleButton.style.display = 'block';
                    }
                } else {
                    toggleButton.style.display = 'block'; // Always show on small screens
                }
            }

            toggleButton.addEventListener('click', function () {
                sidebar.classList.toggle('active');
                updateToggleButtonVisibility(); // Update visibility on click
            });

            window.addEventListener('resize', updateToggleButtonVisibility); // Update visibility on resize
            updateToggleButtonVisibility(); // Initial check
        });

        $(document).ready(function () {
            let cropper;
            const profilePic = $('#profile-pic');
            const imageToCrop = $('#image-to-crop');
            const fileInput = $('#file-input');

            // Make profile pic not clickable initially
            $('#change-image-overlay').hide();

            // Menu item click handling
            $('.menu-item').click(function (e) {
                e.preventDefault();
                $('.content').hide();
                const target = $(this).data('target');
                $(target).show();

                // Remove 'active' class from all menu items
                $('.menu-item').removeClass('active');
                // Add 'active' class to the clicked menu item
                $(this).addClass('active');
            });

            // Profile picture and overlay click handling
            $('#profile-pic, #change-image-overlay').on('click', function () {
                if ($('#edit-profile-btn').is(':hidden')) {
                    fileInput.click();
                }
            });

            // Handle file input change
            fileInput.on('change', function (e) {
                const files = e.target.files;
                const done = function (url) {
                    fileInput.val('');
                    imageToCrop.attr('src', url);
                    $('#cropModal').modal('show');
                };
                let reader;
                let file;
                let url;

                if (files && files.length > 0) {
                    file = files[0];

                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function (e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            // Initialize cropper when modal is shown
            $('#cropModal').on('shown.bs.modal', function () {
                cropper = new Cropper(imageToCrop[0], {
                    aspectRatio: 1,
                    viewMode: 3,
                    autoCropArea: 1,
                    responsive: true,
                });
            }).on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });

            // Handle cropping and saving
            $('#crop-and-save').on('click', function () {
                const canvas = cropper.getCroppedCanvas({
                    width: 100,
                    height: 100,
                });

                profilePic.attr('src', canvas.toDataURL());
                $('#cropModal').modal('hide');
            });

            // Show SweetAlert if session status is set
            @if (session('status'))
                Swal.fire({
                    title: 'Success',
                    text: "{{ session('status') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            // Approve button click handling with SweetAlert confirmation
            document.querySelectorAll('.btn-approve').forEach(function (button) {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to accept this registration?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, accept it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Handle editing profile
            $('#edit-profile-btn').on('click', function () {
                $('.editable').hide();
                $('.form-control').show();
                $(this).hide();
                $('#save-profile-btn').show();
                $('#change-image-overlay').show(); // Enable profile pic change
            });

            // Handle saving profile information
            $('#save-profile-btn').on('click', function () {
                const name = $('#name-input').val();
                const email = $('#email-input').val();
                const contact_num = $('#contact_num-input').val();

                $('#display-name').text(name);
                $('#display-email').text('Email: ' + email);
                $('#display-contact_num').text('Contact No: ' + contact_num);

                $('.editable').show();
                $('.form-control').hide();
                $(this).hide();
                $('#edit-profile-btn').show();
                $('#change-image-overlay').hide(); // Disable profile pic change

                Swal.fire({
                    title: 'Success',
                    text: 'Profile information saved successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>

    <!-- Crop Image Modal -->
    <div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="cropModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-custom" role="document">
            <div class="modal-content modal-content-custom">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="cropper-container">
                        <img id="image-to-crop" src="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop-and-save">Crop and Save</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
