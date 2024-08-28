<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\capscontroller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashControl;
use App\Http\Controllers\HomeControl;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\GuideControl;
use App\Http\Controllers\HomeSettingsController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\NotificationControl;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('LandingPage.home');
});
Route::get('/home', [capscontroller::class, 'home'])->name(name: 'home');
Route::get('/login', [capscontroller::class, 'login'])->name(name: 'login');
Route::post('/login', [capscontroller::class, 'login_post'])->name(name: 'login.post');
Route::get('/registration', [capscontroller::class, 'register'])->name(name: 'register');
Route::post('/registration', [capscontroller::class, 'register_post'])->name(name: 'register.post');
Route::get('/signup', [capscontroller::class, 'signRole'])->name(name: 'signupRole');
Route::get('/visitorlogin', [capscontroller::class, 'visitorLogin'])->name(name: 'visitor_login');
Route::post('/visitor_registration', [capscontroller::class, 'visitorreg_post'])->name(name: 'visitorreg.post');
Route::get('/guidelogin', [capscontroller::class, 'guideLogin'])->name(name: 'guide_login');
Route::post('/guide_registration', [capscontroller::class, 'guidereg_post'])->name(name: 'guidereg.post');
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashview', function () {
        return view('LandingPage.dashboard');
    })->name('dashview');
});

Route::middleware(['auth:guide'])->group(function () {
    Route::get('/guideprofile', function () {
        // Route::post('/hiking_reg/accept/{id}', [HomeControl::class, 'accept_hiking_reg'])->name('hiking_reg.accept');
        // Route::post('/hiking_reg/cancel/{id}', [HomeControl::class, 'cancel_hiking_reg'])->name('hiking_reg.cancel');
        return view('LandingPage.tour_guide.tg_landing');
    })->name(name: 'guideprofile');
});



Route::post('/logout', [capscontroller::class, 'logout'])->name('logout');

// DASHCONTROL
Route::post('/guide/accept', [DashControl::class, 'accept_guide'])->name('guide.accept');
Route::post('/guide/reject', [DashControl::class, 'reject_guide'])->name('guide.reject');
Route::get('/guides/table', [DashControl::class, 'table'])->name('guides.table');

Route::post('/touristspotprofile', [DashControl::class, 'spot_post'])->name(name: 'spot.post');

Route::get('/view-posts', [DashControl::class, 'viewPosts'])->name('view.posts');

Route::post('/hikingacts', [DashControl::class, 'add_hike_act'])->name('activity.post');

// Route::get('/activities/{id}', [DashControl::class, 'show_act'])->name('activities.show');

Route::get('/view-acts', [DashControl::class, 'acts'])->name('acts');

Route::delete('/activities/{id}', [DashControl::class, 'del_acts'])->name('activities.delete');

// Route::post('/activities/update/{id}', [DashControl::class, 'update'])->name('activities.update');

Route::get('/activities/{id}', [DashControl::class, 'show_act'])->name('activities.show');
Route::post('/activities/{id}', [DashControl::class, 'update'])->name('activities.update');

//HOME CONTROL
Route::get('/hike-registration', [HomeControl::class, 'hiking_reg'])->name('hiking_reg');
Route::post('/hike-registration', [HomeControl::class, 'hikingreg_post'])->name('hikingreg.post');
// Route::post('/accept/{id}', [HomeControl::class, 'accept_hiking_reg'])->name('hiking_reg.accept');
Route::get('/pax-members/{id}', [HomeControl::class, 'getPaxMembers'])->name('pax.members');
Route::post('/hiking_reg/accept/{id}', [HomeControl::class, 'accept_hiking_reg'])->name('hiking_reg.accept');
Route::post('/hiking_reg/cancel/{id}', [HomeControl::class, 'cancel_hiking_reg'])->name('hiking_reg.cancel');

Route::post('/cancel-hike', [HomeControl::class, 'cancelHike'])->name('cancel-hike');

Route::post('/cancel-requests/{id}/approve', [DashControl::class, 'approve'])->name('cancel-requests.approve');
Route::post('/cancel-requests/{id}/decline', [DashControl::class, 'decline'])->name('cancel-requests.decline');

Route::get('/fetch-guide-info', [HomeControl::class, 'fetchGuideInfo'])->name('fetch-guide-info');

Route::post('/reschedule-hike', [HomeControl::class, 'rescheduleHike'])->name('reschedule-hike');

Route::post('/hiking_reg/reschedule_approve', [GuideControl::class, 'approveReschedule'])->name('hiking_reg.reschedule_approve');
Route::get('/fetch-resched-date', [GuideControl::class, 'fetchReschedDate'])->name('fetch-resched-date');

Route::post('/paxinfo/verify', [DashControl::class, 'verify'])->name('paxinfo.verify');

Route::post('/timein/store', [HomeControl::class, 'time_in'])->name('timein.post');
Route::post('/timeout/store', [HomeControl::class, 'time_out'])->name('timeout.post');

Route::post('/paxinfo/update-status', [HomeControl::class, 'hike_completed'])->name('status_complete');
// In routes/web.php or routes/api.php
Route::post('/hike-details', [DashControl::class, 'getHikeDetails'])->name('getHikeDetails');

Route::post('/home-settings', [HomeSettingsController::class, 'update_aboutus'])->name('home-settings.update');

Route::post('/things-to-bring/add', [HomeSettingsController::class, 'add_items'])->name('things-to-bring.add');
Route::delete('/things-to-bring/delete/{id}', [HomeSettingsController::class, 'delete_items'])->name('things-to-bring.delete');

Route::post('/rules-regulations/add', [HomeSettingsController::class, 'add_rules'])->name('rules-regulations.add');
Route::delete('/rules-regulations/delete/{id}', [HomeSettingsController::class, 'delete_rules'])->name('rules-regulations.delete');
Route::post('/terms-conditions/update', [HomeSettingsController::class, 'terms_n_condition'])->name('terms-conditions.update');

Route::post('/send-verification-code', [NotificationControl::class, 'sendVerificationCode'])->name('send.verification.code');
Route::post('/verify-code', [NotificationControl::class, 'verifyCode'])->name('verify.code');
Route::post('/reset-password', [NotificationControl::class, 'resetPassword'])->name('reset.password');


