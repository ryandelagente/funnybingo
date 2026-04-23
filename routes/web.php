<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BingoController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminSettingsController;

// Game routes
Route::get('/', [BingoController::class, 'index'])->name('bingo.index');
Route::get('/mobile-host', [BingoController::class, 'mobileHost'])->name('bingo.mobile_host');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

// Static pages
Route::get('/about', [PageController::class, 'about'])->name('page.about');
Route::get('/contact', [PageController::class, 'contact'])->name('page.contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('page.contact.send');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('page.privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('page.terms');

// Dynamic sitemap
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');

// Admin — login (public)
Route::get('/admin/login',  [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout',[AdminController::class, 'logout'])->name('admin.logout');

// Admin — protected
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.posts.index'));
    Route::resource('posts', AdminPostController::class)->names([
        'index'   => 'admin.posts.index',
        'create'  => 'admin.posts.create',
        'store'   => 'admin.posts.store',
        'show'    => 'admin.posts.show',
        'edit'    => 'admin.posts.edit',
        'update'  => 'admin.posts.update',
        'destroy' => 'admin.posts.destroy',
    ]);
    Route::get('/settings',  [AdminSettingsController::class, 'index'])->name('admin.settings');
    Route::put('/settings',  [AdminSettingsController::class, 'update'])->name('admin.settings.update');
});
