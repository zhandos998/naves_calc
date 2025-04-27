<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\VacancyController as AdminVacancyController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\CommodityController as AdminCommodityController;

use App\Http\Controllers\Admin\AdminController;


use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\CommodityController;
use App\Http\Controllers\User\PageController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin_dashboard');
    Route::resource('about', AdminAboutController::class)->only(['edit', 'update']);
    Route::resource('contacts', AdminContactController::class)->only(['edit', 'update']);
    Route::resource('vacancies', AdminVacancyController::class);
    Route::resource('reviews', AdminReviewController::class);
    Route::resource('portfolio', AdminPortfolioController::class);
    Route::resource('commodities', AdminCommodityController::class)->names('admin.commodities');
});


Route::get('/', [PageController::class, 'index']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/contacts', [PageController::class, 'contacts']);
Route::get('/vacancies', [PageController::class, 'vacancies']);
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews', [PageController::class, 'reviews']);
Route::get('/portfolio', [PageController::class, 'portfolio']);

Route::get('/commodities', [CommodityController::class, 'index'])->name('commodities.index');
Route::get('/commodities/{id}', [CommodityController::class, 'show'])->name('commodities.show');
