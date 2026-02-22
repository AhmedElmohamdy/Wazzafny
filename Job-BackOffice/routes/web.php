<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\JobVacanceiesController;
use App\Http\Controllers\JobCategoriesController;
use App\Http\Controllers\JobApplicationsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;




// Dashboard (Admin + Company Owner)
Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin,company-owner'])
    ->name('dashboard');


// ADMIN ONLY ROUTES
Route::middleware(['auth', 'role:admin'])->prefix('Admin')->group(function () {

    // Job Categories
    Route::controller(JobCategoriesController::class)->group(function () {
        Route::get('/GetAll-Job-Categories', 'index')->name('job-categories.index');
        Route::get('/Job-Categories/Create', 'create')->name('job-categories.create');
        Route::post('/Job-Categories', 'save')->name('job-categories.store');
        Route::get('/Job-Categories/Update/{jobCategory}', 'edit')->name('job-categories.edit');
        Route::delete('/Job-Categories/Archive/{jobCategory}', 'archive')->name('job-categories.Archive');
        Route::put('/Job-Categories/Restore/{jobCategory}', 'restore')->name('job-categories.Restore');
    });

    // Users
    Route::controller(UserController::class)->group(function () {
        Route::get('/GetAll-Users', 'index')->name('users.index');
        Route::get('/User/Update/{Users}', 'edit')->name('users.edit');
        Route::post('/User/{Users}', 'update')->name('users.update');
        Route::delete('/User/Archive/{Users}', 'archive')->name('users.Archive');
        Route::put('/User/Restore/{Users}', 'restore')->name('users.Restore');
    });

    // Admins
    Route::controller(AdminController::class)->group(function () {
        Route::get('/GetAll-Admins', 'index')->name('admins.index');
        Route::get('/Admins/Create', 'create')->name('admins.create');
        Route::post('/Admins', 'save')->name('admins.store');
        Route::get('/Admins/Update/{admin}', 'edit')->name('admins.edit');
        Route::delete('/Admins/Delete/{admin}', 'destroy')->name('admins.delete');
    });
});


// ADMIN + COMPANY OWNER ROUTES
Route::middleware(['auth', 'role:admin,company-owner'])
    ->prefix('Admin')
    ->group(function () {

        // Companies
        Route::controller(CompaniesController::class)->group(function () {
            Route::get('/GetAll-Companies', 'index')->name('companies.index');
            Route::get('/Companies/Create', 'create')->name('companies.create');
            Route::post('/Companies', 'save')->name('companies.store'); // Create + Update unified
            Route::get('/Companies/Update/{company}', 'edit')->name('companies.edit');
            Route::delete('/Companies/Archive/{company}', 'archive')->name('companies.Archive');
            Route::put('/Companies/Restore/{company}', 'restore')->name('companies.Restore');
            Route::get('/Companies/{company}/Details', 'details')->name('companies.details');
        });

        // Job Vacancies
        Route::controller(JobVacanceiesController::class)->group(function () {
            Route::get('/GetAll-Job-Vacanceies', 'index')->name('job-vacanceies.index');
            Route::get('/Job-Vacancies/Create', 'create')->name('job-vacanceies.create');
            Route::post('/Job-Vacancies', 'save')->name('job-vacanceies.store');
            Route::get('/Job-Vacancies/Update/{jobVacancy}', 'edit')->name('job-vacanceies.edit');
            Route::delete('/Job-Vacancies/Archive/{jobVacancy}', 'archive')->name('job-vacanceies.Archive');
            Route::put('/Job-Vacancies/Restore/{jobVacancy}', 'restore')->name('job-vacanceies.Restore');
            Route::get('/Job-Vacancies/{jobVacancy}/Details', 'details')->name('job-vacanceies.details');
        });

        // Job Applications
        Route::controller(JobApplicationsController::class)->group(function () {
            Route::get('/GetAll-Job-Applications', 'index')->name('job-applications.index');
            Route::delete('/Job-Applications/Archive/{jobApplication}', 'archive')->name('job-applications.Archive');
            Route::put('/Job-Applications/Restore/{jobApplication}', 'restore')->name('job-applications.Restore');
            Route::get('/Job-Applications/{jobApplication}/Details', 'details')->name('job-applications.details');
        });
    });


 // COMPANY OWNER ONLY ROUTES
Route::middleware(['auth', 'role:company-owner'])->group(function () {
    Route::get('/My-Company', [CompaniesController::class,'details'])->name('My-Company.details');
    Route::get('/My-Company/Edit', [CompaniesController::class,'edit'])->name('My-Company.edit');
    Route::post('/My-Company', [CompaniesController::class,'save'])->name('My-Company.update'); // unified method
});

require __DIR__ . '/auth.php';
