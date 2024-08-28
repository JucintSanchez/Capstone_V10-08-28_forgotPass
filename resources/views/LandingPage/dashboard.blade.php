@extends('LandingPage.layouts.dashboardlayout')

@section('title', 'Administrator')

<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

    $admin = Auth::guard('admin')->user();
    Log::info('Admin updating about us settings:', ['username' => $admin->username]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        .vertical-nav-menu a.active {
            background-color: #0197D3;
            color: white;
        }

        .vertical-nav-menu a.active:hover {
            background-color: #0197D3;
            color: black;
        }
    </style>
</head>

<body>
    
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    @include('LandingPage.modals.accepting_guide')
    @include('LandingPage.modals.proofview')
    @include('LandingPage.modals.update_acts')
        @include('navbar.header')
        @include('navbar.customize')
        
        <!-- Main Content -->
        <div class="app-main">
            @include('navbar.sidebar')
            
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="content" id="dashboard">
                        @include('LandingPage.dashboard_records.dash_visualization') 
                    </div>
                    
                    <div class="content" id="guideRecords" style="display: none;">
                        <div class = "card card-body">
                            @include('LandingPage.dashboard_records.guide_application')
                        </div>     
                    </div>
                    <div class="content" id="acceptedGuide" style="display: none;">
                        <div class = "card card-body">
                        @include('LandingPage.dashboard_records.guide_records')
                        </div>
                    </div>
                    <div class="content" id="hikerRec" style="display: none;">
                            <div class = "card card-body">
                            @include('LandingPage.dashboard_records.hikers_recs')
                            </div>
                        </div>
                        <div class="content" id="edit_tourist_spot" style="display: none;">
                            
                                @include('LandingPage.edit_tourist_spot')
                        
                        </div>
                        <div class="content" id="hiking_act" style="display: none;">
                            <div>
                                @include('LandingPage.Hiking_act.hiking_acts')
                            </div>    
                        </div>
                        <div class="content" id="incident_rec" style="display: none;">
                            <div class = "card card-body">
                                @include('LandingPage.dashboard_records.incident')
                            </div>    
                        </div>
                        <div class="content" id="cancel_rec" style="display: none;">
                            <div class = "card card-body">
                                @include('LandingPage.dashboard_records.cancel_recs')
                            </div>    
                        </div>
                        <div class="content" id="home_prof" style="display: none;">
                                @include('LandingPage.home_profile')   
                        </div>
                        <div class="content" id="hiking_recs" style="display: none;">
                            <div class = "card card-body">
                                @include('LandingPage.dashboard_records.hiking_registration_recs')
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logout Form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.menu-item').click(function (e) {
                e.preventDefault();
                $('.content').hide();
                var target = $(this).data('target');
                $(target).show();

                // Remove 'active' class from all menu items
                $('.menu-item').removeClass('active');
                // Add 'active' class to the clicked menu item
                $(this).addClass('active');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
