<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Design</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/kMVq3Aq0elWxJGfZLZy6CEur6FfPsn9Fg8B3rmT3xjcmxwXwVs2ctvCr2vukH3+FO2lq7U+pXyD9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        .app-sidebar {
            width: 250px;
            background-color: #ffffff;
            color: #333;
            height: 100vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            overflow-y: auto;
        }

        .app-header__logo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            color: #fff;
        }

        .app-header__logo .logo-src {
            font-size: 1.5rem;
        }

        .scrollbar-sidebar {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1rem 0;
        }

        .app-sidebar__inner {
            padding: 0 1rem;
        }

        .vertical-nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .vertical-nav-menu li {
            margin-bottom: 1rem;
        }

        .app-sidebar__heading {
            font-size: 0.85rem;
            text-transform: uppercase;
            margin-bottom: 1rem;
            color: #00c897;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            color: #333;
            transition: background-color 0.2s ease-in-out;
        }

        .menu-item:hover {
            background-color: #f1f1f1;
        }

        .menu-item.active {
            background-color: #2e8b57;
            color: white;
        }

        .menu-item i {
            margin-right: 1rem;
            color: black;
            transition: color 0.2s ease-in-out;
        }

        .menu-item.active i {
            color: white;
        }

        .theme-switch {
            margin-top: auto;
            padding: 1rem;
            text-align: center;
        }

        .theme-switch button {
            width: 100%;
            padding: 0.5rem;
            border: none;
            background-color: #00c897;
            color: #fff;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .theme-switch button:hover {
            background-color: #00b586;
        }

        .vertical-nav-menu a.active {
            background-color: #2e8b57;
            color: white;
            border-radius: 15px;
        }

        #applicants {
            font-size: 13px;
        }

        .vertical-nav-menu a.active:hover {
            background-color: #1b5233;
            color: white;
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

        .sign-out button:hover {
            background-color: rgba(152, 251, 152, 0.8); /* Darker mint green on hover */
        }

        .sign-out button i {
            margin-right: 0.5rem;
        }

    </style>
</head>
<body>
    <div class="app-sidebar sidebar-shadow">
        <div class="app-header__logo">
            <div class="logo-src"></div>
            <div class="header__pane ml-auto">
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="scrollbar-sidebar">
            <div class="app-sidebar__inner">
                <ul class="vertical-nav-menu">
                    <li class="app-sidebar__heading">Dashboard</li>
                    <li>
                        <a href="#" data-target="#dashboard" class="menu-item active">
                            <i class="fa-sharp fa-solid fa-gauge"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="app-sidebar__heading">Records</li>
                    <li>
                        <a href="#">
                            <i class="fas fa-users"></i>
                            Users Records
                            <i class="fas fa-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="#" class="menu-item" data-target="#acceptedGuide">
                                    <i class="metismenu-icon"></i>
                                    Tourist Guide's Records
                                </a>
                            </li>
                            <li>
                                <a href="#" class="menu-item" data-target="#hikerRec">
                                    <i class="metismenu-icon"></i>
                                    Hiker's Account
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="menu-item" data-target="#guideRecords" id="applicants">
                            <i class="fas fa-file-alt"></i>
                            Guide Application Request
                        </a>
                    </li>
                    <li>
                        <a href="#" class = "menu-item" data-target= "#hiking_recs">
                            <i class="fas fa-hiking"></i>
                            Hiking Records
                        </a>
                    </li>
                    <li>
                        <a href="#" class="menu-item" data-target="#incident_rec">
                            <i class="fas fa-exclamation-triangle"></i>
                            Incident Reports
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-money-check-alt"></i>
                            Payment Records
                        </a>
                    </li>
                    <li>
                        <a href="#" class="menu-item" data-target="#cancel_rec">
                            <i class="fas fa-window-close"></i>
                            Cancellation Request 
                        </a>
                    </li>
                    <li class="app-sidebar__heading">Tourist Spot Settings</li>
                    <li>
                        <a href="#" class="menu-item" data-target="#edit_tourist_spot">
                            <i class="fas fa-share-square"></i>
                            Tourist Spot Post
                        </a>
                    </li>
                    <li>
                        <a href="#" class="menu-item" data-target="#home_prof">
                            <i class="fas fa-home"></i>
                            Home Profile
                        </a>
                    </li>
                    <li>
                        <a href="#" class="menu-item" data-target="#hiking_act">
                            <i class="fas fa-hiking"></i>
                            Hiking Activities
                        </a>
                    </li>
                </ul>
                <div class="sign-out">
                    <button type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Sign-out
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
