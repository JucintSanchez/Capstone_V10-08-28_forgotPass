<!-- Home Navbar -->
<?php
    use App\Models\SystemNotif;

    $user = Auth::guard('hiker')->user();
    $hikerId = $user ? $user->hiker_id : null;
    $username = $user ? $user->username : 'Login/Register';

    $notifications = $hikerId ? SystemNotif::where('hiker_id', $hikerId)->get() : collect();
    $notificationCount = $notifications->count();

    Log::info('Logged-in hiker ID: ' . ($hikerId ?? 'Not logged in'));
?>

<style>
    .badge {
        font-size: 0.8rem;
        position: absolute;
        top: 0;
        right: 0;
        padding: 0.3em 0.5em;
        border-radius: 50%;
        transform: translate(50%, -50%);
        background-color: red; /* Background color for the badge */
        color: white; /* Text color for the badge */
    }
    .navbar-brand {
        font-size: 1.2rem; /* Increase the font size of the brand */
    }
    .navbar-toggler {
        padding: 0.5rem; /* Adjust the padding for the toggler button */
    }

    .nav-link {
        position: relative;
        display: flex;
        align-items: left;
        padding: 0.5rem;
        color: white; /* Ensure the text is white by default */
    }
    .nav-link p {
        color: white; 
        font-weight: 600;
        margin: 0; /* Ensure no extra margins on the paragraph */
    }
    .nav-link i {
        font-size: 1rem; /* Adjust font size to match text */
        margin-right: 8px; /* Add space between icon and text */
    }
    .navbar {
        transition: background-color 0.3s;
    }
    .navbar.navbar-colored {
        background-color: rgba(0, 128, 0, 0.8); /* Green color */
    }
    .dropdown-menu {
        background-color: rgba(0, 128, 0, 0.9); /* Dark green background */
        color: white; /* White text color */
    }
    .dropdown-item {
        color: white; /* White text color */
    }
    .dropdown-item:hover, .dropdown-item:focus {
        background-color: rgba(0, 128, 0, 0.7); /* Lighter green on hover/focus */
        color: white; /* White text color */
    }
    .dropdown-divider {
        border-color: rgba(255, 255, 255, 0.1); /* Light divider color */
    }
  .navbar-nav {
        display: flex;
        /* align-items: center; */
     }  
    .navbar-nav .nav-item {
        display: flex;
        align-items: center;
    }
    .navbar-nav .nav-item .nav-link {
        display: flex;
        align-items: center;
    } 
    .navbar-nav .dropdown-menu {
        position: ;
        float: none;
    }
    .dropdown:hover .dropdown-menu {
        display: block;
    } 
</style>

<nav class="navbar navbar-expand-lg fixed-top navbar-transparent" id="navbar" color-on-scroll="400">
    <div class="container">
        <div class="dropdown button-dropdown">
            <a href="#pablo" class="dropdown-toggle" id="navbarDropdown" data-toggle="dropdown">
                <span class="button-bar"></span>
                <span class="button-bar"></span>
                <span class="button-bar"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-header">Option</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="checkLoginStatus()">Hike Registration</a>
                <a class="dropdown-item" href="#spotPost" >Post</a>
                <a class="dropdown-item" data-mdb-modal-init data-mdb-target="#remindersModal">Rules and Regulations</a> 
                <!-- <a class="dropdown-item" href="#show-weather">Weather</a> -->
                <a class="dropdown-item" href="#registration-stats">Registration Status</a>
                <a class="dropdown-item" href="#time-in-out">Time -in / Time-out</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Leaderboards</a>
                <!-- <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">About Us</a> -->
            </div>
        </div>
        <div class="navbar-translate">
            <a class="navbar-brand" href="" rel="tooltip" title="Project From Quadra-CinTech" data-placement="bottom" target="_blank">
                SmartHike
            </a>
            <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar top-bar"></span>
                <span class="navbar-toggler-bar middle-bar"></span>
                <span class="navbar-toggler-bar bottom-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse justify-content-end" id="navigation" style="background: black;">
            <ul class="navbar-nav">
                <li class="nav-item" >
                    <a class="nav-link" rel="tooltip" title="Hike Registration" data-mdb-modal-init data-mdb-target="#hike_reg_modal">
                        <i class="fas fa-hiking"></i>
                        <p class="d-lg-none d-xl-none">Hike Registration</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" rel="tooltip" title="Blogs" data-placement="bottom" href="#spot-view" onclick="scrollToSpotPost(event)">
                        <i class="fa-brands fa-blogger"></i>
                        <p class="d-lg-none d-xl-none">Blogs</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" rel="tooltip" title="Rules and Regulation" data-mdb-modal-init data-mdb-target="#remindersModal">
                        <i class="fas fa-book"></i>
                        <p class="d-lg-none d-xl-none">Rules and Regulations</p>
                    </a>
                </li>
                <li class="nav-item">
    <a class="nav-link" rel="tooltip" title="Registration Status" data-placement="bottom" href="#registration-stats" onclick="scrollToReg(event)">
        <i class="fas fa-clipboard-check"></i>
        <p class="d-lg-none d-xl-none">Registration Status</p>
    </a>
</li>
                <!-- <li class="nav-item">
                    <a class="nav-link" rel="tooltip" title="Weather" data-placement="bottom" href="#show-weather" target="_blank">
                        <i class="fas fa-cloud-sun"></i>
                        <p class="d-lg-none d-xl-none">Weather</p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" rel="tooltip" title="Leaderboard" data-placement="bottom" href="" target="_blank">
                        <i class="fas fa-trophy"></i>
                        <p class="d-lg-none d-xl-none">Leaderboards</p>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdownNotifications" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-2x"></i>
                        @if ($notificationCount > 0)
                            <span class="badge badge-danger">{{ $notificationCount }}</span>
                        @endif
                        <p class="d-lg-none d-xl-none">Notifications</p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownNotifications">
                        @forelse ($notifications as $notification)
                            <a class="dropdown-item notification-link" href="#registration-stats">
                                {{ $notification->notification }}
                            </a>
                        @empty
                            <a class="dropdown-item" href="#">No notifications</a>
                        @endforelse
                    </div>
                </li>
                <li class="nav-item dropdown">
                    @if ($username !== 'Login/Register')
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $username }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownUser">
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign-out</a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a class="nav-link" href='{{ route("login") }}'>Login / Register</a>
                    @endif
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Have an issue?</a>
                </li>
            </ul>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</nav>
<!-- End Navbar -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function checkLoginStatus() {
        <?php if ($username === 'Login/Register') { ?>
            Swal.fire({
                icon: 'warning',
                title: 'Login First',
                text: 'You need to log in before you can register for a hike.',
                confirmButtonText: 'OK'
            });
        <?php } else { ?>
            $('#hike_reg_modal').modal('show');
        <?php } ?>
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.notification-link').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                var target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    document.getElementById('top-part').style.display = 'none';
                    document.getElementById('about-us').style.display = 'none';
                    document.getElementById('contact-us').style.display = 'none';
                    document.getElementById('show-weather').style.display = 'none';
                    document.getElementById('spot-view').style.display = 'none';
                    document.getElementById('registration-stats').style.display = 'block';
                    
                    window.scrollTo({
                        top: target.offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
        function scrollToSpotPost(event) {
            event.preventDefault();
            document.querySelector('#spot-view').scrollIntoView({ behavior: 'smooth' });
        }
        document.addEventListener('DOMContentLoaded', function() {
        function scrollToReg(event) {
            event.preventDefault();

            // Hide other sections
            document.getElementById('top-part').style.display = 'none';
            document.getElementById('about-us').style.display = 'none';
            document.getElementById('contact-us').style.display = 'none';
            document.getElementById('show-weather').style.display = 'none';
            document.getElementById('spot-view').style.display = 'none';
            document.getElementById('offered_activities').style.display = 'none';

            // Display the registration stats section
            const regSection = document.querySelector('#registration-stats');
            regSection.style.display = 'block';

            // Smoothly scroll to the registration stats section
            regSection.scrollIntoView({ behavior: 'smooth' });
        }

        document.querySelector('a[href="#registration-stats"]').addEventListener('click', scrollToReg);
    });

        const navbar = document.getElementById('navbar');
        const colorOnScroll = parseInt(navbar.getAttribute('color-on-scroll'), 10);

        function changeNavbarColor() {
            if (window.scrollY >= colorOnScroll) {
                navbar.classList.add('navbar-colored');
                navbar.classList.remove('navbar-transparent');
            } else {
                navbar.classList.add('navbar-transparent');
                navbar.classList.remove('navbar-colored');
            }
        }

        window.addEventListener('scroll', changeNavbarColor);
        changeNavbarColor(); // Initialize on page load
    });
</script>

