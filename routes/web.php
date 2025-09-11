<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobseekerController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserAvatarController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\CarersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Middleware\CheckUserByUserType;
use App\Models\Employer;
use App\Models\Jobseeker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about'); 

// AUTH ROUTES (login/register)
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->name('login.store');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

// Google Socialite routes
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Jobseeker/Employer type of user 
Route::get('/auth/choose-user-type', [SocialiteController::class, 'showChooseUserType'])->name('auth.choose-user-type');
Route::post('/auth/complete-registration', [SocialiteController::class, 'completeRegistration'])->name('auth.complete-registration');

// FORGOT PASSWORD
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard'); 

    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

    Route::get('/jobs/search', [JobController::class, 'search'])->name('jobs.search');
    
    Route::middleware(CheckUserByUserType::class. ':' . Employer::class)->group(function () {
        Route::prefix('jobs')->group(function() {
            Route::get('/create', [JobController::class, 'create'])->name('jobs.create');
            Route::post('/', [JobController::class, 'store'])->name('jobs.store');
            Route::get('/my-jobs', [JobController::class, 'showMyJobs'])->name('jobs.show-my-jobs');

            Route::put('/{job}', [JobController::class, 'update'])->name('jobs.update');
            Route::post('/{job}/deactivate', [JobController::class, 'deactivate'])->name('jobs.deactivate');
            Route::post('/{job}/activate', [JobController::class, 'activate'])->name('jobs.activate');
            Route::delete('/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
            Route::get('/{job}/applications', [ApplicationController::class, 'employerByJob'])->name('applications.employer.by-job'); 
        });

        
        Route::get('/jobseeker/{jobseeker}/review', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/jobseeker/{jobseeker}/review', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/jobseeker/{jobseeker}/reviews', [ReviewController::class, 'show'])->name('reviews.show');

        Route::get('/employer/applications', [ApplicationController::class, 'employerIndex'])->name('applications.employer.index');
        
        Route::get('/employer/applications/{application}', [ApplicationController::class, 'employerShow'])->name('applications.employer.show');
        Route::patch('/applications/{application}/approve', [ApplicationController::class, 'approve'])->name('applications.approve');
        Route::patch('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
    });

    Route::middleware(CheckUserByUserType::class. ':' . Jobseeker::class)->group(function () {
        Route::get('/applications', [ApplicationController::class, 'show'])->name('applications.index');
        Route::delete('/applications/job/{jobId}', [ApplicationController::class, 'destroy'])->name('applications.destroy');

        Route::prefix('jobs')->group(function() {
            // Applying for job
            Route::get('/{job}/apply', [ApplicationController::class, 'create'])->name('applications.create');
            // rutu post ćemo morati urediti bolje
            Route::post('/{job}/apply', [ApplicationController::class, 'store'])->name('applications.store');
        });

        // Saved Jobs
        Route::get('/saved', [SavedJobController::class, 'index'])->name('jobs.saved');
        Route::post('/save/{jobId}', [SavedJobController::class, 'store'])->name('jobs.save');
        Route::delete('/unsave/{jobId}', [SavedJobController::class, 'destroy'])->name('jobs.unsave');

    });

    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show')->middleware(CheckUserByUserType::class . ':' . Jobseeker::class . ',' . Employer::class);

    Route::get('/employer/applications', [ApplicationController::class, 'employerIndex'])->name('applications.employer.index');

});

// JOBSEEKER AND EMPLOYER PROFILE
Route::middleware('auth')->group(function () {
    // ovo je ruta koja vodi na /profile, i ovisno o vrsti usera vodi ga na njihov profil
    Route::get('/profile', function () {
        return Auth::user()->isJobseeker()
            ? redirect()->route('jobseeker.profile.show')
            : redirect()->route('employer.profile.show');
    })->name('profile.home');

    Route::middleware(CheckUserByUserType::class. ':' . Jobseeker::class)->group(function () {
        Route::prefix('jobseeker/profile')->name('jobseeker.profile.')->group(function () {
            Route::get('/',    [JobseekerController::class, 'show'])->name('show');
            Route::get('/edit',[JobseekerController::class, 'edit'])->name('edit');
            Route::patch('{jobseeker}',  [JobseekerController::class, 'update'])->name('update');
            Route::delete('/', [JobseekerController::class, 'destroy'])->name('destroy');
        });
    });
    
    Route::middleware(CheckUserByUserType::class. ':' . Employer::class)->group(function () {
        Route::prefix('employer/profile')->name('employer.profile.')->group(function () {
            Route::get('/',    [EmployerController::class, 'show'])->name('show');
            Route::get('/edit',[EmployerController::class, 'edit'])->name('edit');
            Route::patch('{employer}',  [EmployerController::class, 'update'])->name('update');
        });
    });
    
    // PROFILE PICTURE
    Route::post('/profile/upload-photo', [UserAvatarController::class, 'upload'])->name('profile.upload-photo');
    Route::delete('/profile/remove-photo', [UserAvatarController::class, 'remove'])->name('profile.remove-photo');

    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset.update');
    Route::get('/profile/password', [UserController::class, 'editPassword'])->name('password.edit');
    Route::patch('/profile/password', [UserController::class, 'updatePassword'])->name('password.profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/jobseeker/{id}', [JobseekerController::class, 'showPublic'])->name('jobseeker.show');

    Route::get('/carers', [CarersController::class, 'index'])->name('carers')->middleware(CheckUserByUserType::class. ':' . Employer::class);
});