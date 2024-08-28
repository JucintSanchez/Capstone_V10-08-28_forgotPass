@extends('LandingPage.modals.hike_reg')
@extends('LandingPage.modals.reminders')

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="../assets/img/tab-logo.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>
            SmartHike Home Page
        </title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <!-- CSS Files -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../assets/css/now-ui-kit.css?v=1.3.0" rel="stylesheet" />

        <style>
            body {
    position: relative;
    margin: 0;
    padding: 0;
    height: 100vh; /* Ensure the body takes the full viewport height */
}

/* Blurred background applied to the entire body */
.background-blur {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('../assets/img/blurr.jpg') center center / cover no-repeat;
    filter: blur(8px);
    z-index: -1; /* Ensure the background is behind all content */
}

.dropdown-item.active {
    background: white;
}

#top-part {
    position: relative;
    z-index: 2;
    height: 40rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-bottom-left-radius: 100px;
    border-bottom-right-radius: 100px;
    background: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
    margin-bottom: -5rem; /* Adjust the negative margin as needed for overlap */
    text-align: center; /* Center the text within the container */
}

.section {
    padding: 2rem;
    background: rgba(255, 255, 255, 0.8); /* Semi-transparent background for sections */
    border-bottom: 1px solid black;
    width: 100%;
}

.offered-activities {
    border: none;
}

.footer {
    background: white; /* Semi-transparent background */
}

#spot-view {
    position: relative;
    overflow: hidden;
    z-index: 1; /* Ensure it’s above the pseudo-element */
}

#spot-view::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('../assets/img/camp.jpg') center center no-repeat;
    background-size: cover;
    filter: blur(5px);
    z-index: -1; /* Make sure it’s behind the content */
}

.register {
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-top: 15rem;
}

.book-now-button {
    background-color: green; /* Green background color */
    color: white; /* White text color */
    border: 2px solid black; /* Black border */
    border-radius: 25px;
    padding: 0.5rem 2rem;
    font-size: 1.2rem;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s, color 0.3s;
    outline: none;
  
    overflow: hidden;
    margin-bottom: 1rem; /* Add some space between buttons */
}

.book-now-button::after {
    content: '';
    
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.2); /* Semi-transparent white overlay */
    opacity: 0;
    transition: opacity 0.3s;
}

.book-now-button:hover::after {
    opacity: 1; /* Show overlay on hover */
}

.book-now-button:hover {
    background-color: #618264; /* Darker green for hover */
    transform: scale(1.05); /* Slightly increase size on hover */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow effect */
    color: black; /* Change text color to black */
}

.book-now-button:active {
    background-color: #4D6A47; /* Even darker green when clicked */
    transform: scale(0.98); /* Slightly decrease size on click */
}

.book-now-button-white-border {
    border: 2px solid white; /* White border */
}

#scroll-top-button {
    display: none; /* Hidden by default */
    position: fixed; /* Fixed position */
    bottom: 20px; /* Place it at the bottom of the page */
    left: 20px; /* Place it 20px from the right */
    z-index: 99; /* Ensure it is above other content */
    border: none; /* Remove borders */
    outline: none; /* Remove outline */
    background-color: green; /* Set a background color */
    color: white; /* Text color */
    cursor: pointer; /* Add a mouse pointer on hover */
    width: 50px; /* Set width */
    height: 50px; /* Set height */
    border-radius: 50%; /* Make it a circle */
    font-size: 18px; /* Increase font size */
    transition: opacity 0.3s ease; /* Smooth transition for showing/hiding */
    display: flex;
    justify-content: center;
    align-items: center;
}

#scroll-top-button:hover {
    background-color: darkgreen; /* Darker background on hover */
}

/* Back Button */
#back-button {
    display: none; /* Hidden by default */
    position: fixed; /* Fixed position */
    bottom: 20px; /* Place it at the bottom of the page */
    right: 20px; /* Place it 20px from the right */
    z-index: 99; /* Ensure it is above other content */
    border: none; /* Remove borders */
    outline: none; /* Remove outline */
    background-color: green; /* Set a background color */
    color: white; /* Text color */
    cursor: pointer; /* Add a mouse pointer on hover */
    width: 50px; /* Set width */
    height: 50px; /* Set height */
    border-radius: 50%; /* Make it a circle */
    font-size: 18px; /* Increase font size */
    transition: opacity 0.3s ease; /* Smooth transition for showing/hiding */
    display: flex;
    justify-content: center;
    align-items: center;
}

#back-button:hover {
    background-color: darkgreen; /* Darker background on hover */
}

        </style>
    </head>

    <body class="landing-page sidebar-collapse">
        <div class="background-blur"></div> <!-- Blurred background -->
        @include('navbar.home_nav')
        <div class="content active">
            <div class="wrapper">
                    <div id="top-part" class="section section-top-part">
                        @include('LandingPage.home.top_part')
                        <div class="register" >
                            <button class="book-now-button">HIKE NOW</button>
                            <button class="book-now-button" id="learn-more-button">LEARN MORE</button>
                        </div>
                    </div>
                <!-- Combined Sections -->
                <div id="about-us" class="section section-about-us">
                    @include('LandingPage.home.about_us')
                </div>
                <div id="offered_activities" class="section section-offered_activities">
                    @include('LandingPage.home.offered_activities')
                </div>
                <div id="spot-view" class="section section-team text-center">
                    <div class="container">
                        <h2 class="title" style="color:white;">Tourist Spot Posts</h2>
                        @include('LandingPage.home.scrollable_image')
                    </div>
                </div>
                <div id="contact-us">
                    @include('LandingPage.home.contact_us')
                </div>
                <div id="show-weather">
                    @include('LandingPage.weather')
                </div>
                <div id="registration-stats" class="section section-team text-center" style="display:none;">
                    <div class="card-body">
                        <h2 class="title">Registration Status</h2>
                        @include('LandingPage.home.registration_stats')
                    </div>
                </div>
                <div id="learn-more-section" class="section section-learn-more" style="display: none; margin-top: 5rem;">
                    @include('LandingPage.home.learn_more')
                </div>
                <div id="time-in-out" class="section section-team text-center" style="display:none;">
                    <div class="card-body">
                        <h2 class="title">Time-In / Time-Out</h2>
                        @include('LandingPage.home.timein_out')
                    </div>
                </div>
                <footer class="footer footer-default">
                    <div class="container">
                        <div class="copyright" id="copyright">
                            &copy;
                            <script>
                                document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                            </script>, Designed by
                            <a href="" target="_blank">Quadra CinTech</a>. Coded by
                            <a href="" target="_blank">Our Team</a>.
                        </div>
                    </div>
                </footer>
                <button onclick="scrollToTop()" id="scroll-top-button" title="Go to top">
                    <i class="fas fa-arrow-up"></i>
                </button>
                <button onclick="goBack()" id="back-button" title="Go back">
                    <i class="fas fa-arrow-left"></i>
                </button>
            </div>
        </div>
        <!--   Core JS Files   -->
        <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
        <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
        <script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
        <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
        <script src="../assets/js/plugins/bootstrap-switch.js"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
        <!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
        <script src="../assets/js/plugins/bootstrap-datepicker.js" type="text/javascript"></script>
        <!--  Google Maps Plugin    -->
        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
        <!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
        <script src="../assets/js/now-ui-kit.js?v=1.3.0" type="text/javascript"></script>
        
        <!-- Custom JS to handle section visibility -->
        <script>
    const sections = ['top-part', 'about-us', 'offered_activities', 'spot-view', 'contact-us', 'show-weather'];
    const hiddenSections = ['registration-stats', 'learn-more-section', 'time-in-out'];
    let currentSection = 'top-part';
    let previousSection = '';

    function showSection(sectionId) {
        previousSection = currentSection;
        currentSection = sectionId;
        sections.concat(hiddenSections).forEach(section => {
            document.getElementById(section).style.display = section === sectionId ? 'block' : 'none';
        });
        updateBackButtonVisibility();
    }

    function updateBackButtonVisibility() {
        const backButton = document.getElementById('back-button');
        backButton.style.display = currentSection === 'top-part' ? 'none' : 'block';
    }

    function goBack() {
        if (previousSection === 'top-part') {
            sections.forEach(section => {
                document.getElementById(section).style.display = 'block';
            });
            hiddenSections.forEach(section => {
                document.getElementById(section).style.display = 'none';
            });
            currentSection = 'top-part';
        } else {
            showSection(previousSection);
        }
        updateBackButtonVisibility();
    }

    document.querySelector('.dropdown-item[href="#spotPost"]').addEventListener('click', function() {
        showSection('spot-view');
    });

    document.querySelector('.dropdown-item[href="#registration-stats"]').addEventListener('click', function() {
        showSection('registration-stats');
    });

    document.querySelector('.dropdown-item[href="#time-in-out"]').addEventListener('click', function() {
        showSection('time-in-out');
    });

    document.getElementById('learn-more-button').addEventListener('click', function() {
        showSection('learn-more-section');
    });

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    window.onscroll = function() {
        const scrollTopButton = document.getElementById('scroll-top-button');
        scrollTopButton.style.display = document.documentElement.scrollTop > 200 ? 'block' : 'none';
    }

    updateBackButtonVisibility(); // Initial check
</script>

    </body>
</html>
