<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobVacanciesController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth', 'role:job-seeker'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/Job-Application/{id?}', [JobApplicationController::class, 'index'])->name('Job-Application.index');
    Route::get('/Job-Vacancies/{id}', [JobVacanciesController::class, 'show'])->name('Job-Vacancies.show');
    Route::get('/Job-Vacancies/apply/{id}', [JobVacanciesController::class, 'apply'])->name('Job-Application.apply');
    Route::post('/Job-Vacancies/apply/{id}', [JobVacanciesController::class, 'store'])->name('Job-Application.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/TestAI', [JobVacanciesController::class, 'Testai'])->name('Job-Vacancies.TestAI');



    Route::get('/test-cloudinary', function () {
    try {
        // Test 1: Check config values
        $cloudName = config('cloudinary.cloud_name');
        $apiKey = config('cloudinary.api_key');
        $apiSecret = config('cloudinary.api_secret');
        
        $configTest = [
            'cloud_name' => $cloudName ? '✅ Set: ' . $cloudName : '❌ Missing',
            'api_key' => $apiKey ? '✅ Set: ' . substr($apiKey, 0, 6) . '...' : '❌ Missing',
            'api_secret' => $apiSecret ? '✅ Set: ' . substr($apiSecret, 0, 6) . '...' : '❌ Missing',
        ];
        
        // Test 2: Try to use Cloudinary facade
        $cloudinaryTest = 'Not tested';
        try {
            $config = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::getUrl('test');
            $cloudinaryTest = '✅ Cloudinary Facade Works';
        } catch (\Exception $e) {
            $cloudinaryTest = '❌ Error: ' . $e->getMessage();
        }
        
        return response()->json([
            'status' => 'Cloudinary Configuration Test',
            'config_values' => $configTest,
            'cloudinary_facade' => $cloudinaryTest,
            'env_check' => [
                'CLOUDINARY_CLOUD_NAME' => env('CLOUDINARY_CLOUD_NAME') ? '✅ Set' : '❌ Missing',
                'CLOUDINARY_API_KEY' => env('CLOUDINARY_API_KEY') ? '✅ Set' : '❌ Missing',
                'CLOUDINARY_API_SECRET' => env('CLOUDINARY_API_SECRET') ? '✅ Set' : '❌ Missing',
            ]
        ], 200, [], JSON_PRETTY_PRINT);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500, [], JSON_PRETTY_PRINT);
    }
})->name('test.cloudinary');
});




require __DIR__.'/auth.php';
