<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobseekerController;
use App\Http\Controllers\UserAvatarController;
use App\Http\Controllers\SavedJobController;
use App\Models\Jobseeker;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about'); 
Route::view('/dashboard', 'dashboard')->name('dashboard')->middleware('auth');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->name('login.store');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

// SAVED JOBS
Route::get('/jobs/saved', [SavedJobController::class, 'index'])->name('jobs.saved')->middleware('auth');
Route::post('/jobs/save/{jobId}', [SavedJobController::class, 'store'])->name('jobs.save')->middleware('auth');
Route::delete('/jobs/unsave/{jobId}', [SavedJobController::class, 'destroy'])->name('jobs.unsave')->middleware('auth');

// JOBS ====> ovdje namjestiti kao dolje da bude lijepo i uredno
Route::prefix('jobs')->group(function() {
    Route::get('/create', [JobController::class, 'create'])->name('jobs.create')->middleware('auth');
    Route::get('/', [JobController::class, 'index'])->name('jobs.index')->middleware('auth');
    Route::post('/', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/my-jobs', [JobController::class, 'showMyJobs'])->name('jobs.show-my-jobs')->middleware('auth');

    Route::put('/{job}', [JobController::class, 'update'])->name(('jobs.update'))->middleware('auth');
    Route::delete('/{job}', [JobController::class, 'destroy'])->name('jobs.destroy')->middleware('auth');
    Route::get('/{job}', [JobController::class, 'show'])->name('jobs.show')->middleware('auth');
});

// APPLICATIONS
Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index')->middleware('auth');

// JOBSEEKER AND EMPLOYER PROFILE
Route::middleware('auth')->group(function () {
    // ovo je ruta koja vodi na /profile, i ovisno o vrsti usera vodi ga na njihov profil
    Route::get('/profile', function () {
        return auth()->user()->isJobseeker()
            ? redirect()->route('jobseeker.profile.show')
            : redirect()->route('employer.profile.show');
    })->name('profile.home');

    // JOBSEEKER
    Route::prefix('jobseeker/profile')->name('jobseeker.profile.')->group(function () {
        Route::get('/',    [JobseekerController::class, 'show'])->name('show');
        Route::get('/edit',[JobseekerController::class, 'edit'])->name('edit');
        Route::patch('{jobseeker}',  [JobseekerController::class, 'update'])->name('update');
        Route::delete('/', [JobseekerController::class, 'destroy'])->name('destroy');
    });

    // EMPLOYER
    Route::prefix('employer/profile')->name('employer.profile.')->group(function () {
        Route::get('/',    [EmployerController::class, 'show'])->name('show');
        Route::get('/edit',[EmployerController::class, 'edit'])->name('edit');
        Route::patch('{employer}',  [EmployerController::class, 'update'])->name('update');
    });
});


Route::get('/jobseeker/{id}', [JobseekerController::class, 'showPublic'])->name('jobseeker.show')->middleware('auth');

// PROFILE PICTURE
Route::post('/profile/upload-photo', [UserAvatarController::class, 'upload'])->name('profile.upload-photo');
Route::delete('/profile/remove-photo', [UserAvatarController::class, 'remove'])->name('profile.remove-photo');

Route::get('/carers', function() {
    $jobseekers = Jobseeker::with('authParent')->get();

    return view('jobseekers', compact('jobseekers'));
})->name('carers')->middleware('auth');

/* RUTE KOJE SE TREBAJU DEFINIRATI */

/* == AUTENTIFIKACIJA I UPRAVLJANJE KORISNICIMA  ==

    post/register                       - registracija novog korisnika
    post/login                          - prijava korisnika

    get/me                              - dohvaćanje trenutnog korisnika
    get/users/:id                       - dohvaćanje korisnika prema ID-ju
    put/users/profile                   - azuriranje profila korisnika
    post/users/profile-picture          - ucitavanje profilne slike
    get/users/jobseekers                - dohvacanje svih jobseekera
    get/users/profile-stats             - dohvacanje statistike profila
    post/forgot-password                - zahtjev za resetiranje zaboravljene lozinke
    post/change-password                - promjena lozinke

    == JOBS ==

    post/jobs/create                    - kreiranje novog posla
    get/jobs                            - dohvacanje svih poslova
    get/jobs/my-jobs                    - dohvacanje oglasa za posao koji je kreirao trenutni poslodavac
    put/jobs/:id                        - azuriranje oglasa za posao
    delete/jobs/:id                     - brisanje oglasa
    get/jobs/:id                        - dohvacanje detalja o oglasu
    get/jobs/saved/check/job:id         - projvera je li trenutni korisnik spremio oglas za posao
    get/jobs/saved-jobs                 - dohvacanje spremljenih poslova
    post/jobs/saved/:jobId              - spremanje oglasa za posao
    delete/jobs/saved/:jobId            - uklanjanje spremljnoeg oglasa za posao
    
    == PRIJAVE ZA POSAO == 

    get/applications/job/:jobId         - dohvacanje svih prijava za odredeni posao (samo za poslodavce)
    get/applications/my-applications    - dohvacanje prijava trenutnog korisnika(jobseeker)
    get/applications/employer-applications - dohvacanje svih prijava za poslodavca
    get/applications/check/:jobId       - provjera je li korisnik vec prijavio za posao
    post/applications/apply             - prijava za posao
    get/applications/:id                - dohvacanje detalja o prijavi za posao
    delete/applications/:id             - poovlacanje prijave za posao
    put/applications/:id/status         - azuriranje statusa prijave za posao(za poslodavce)
    
    == NOTIFIKACIJE ==

    notifikacije -- to ćemo zadnje

    == RECENZIJE ==

    recenzije





*/