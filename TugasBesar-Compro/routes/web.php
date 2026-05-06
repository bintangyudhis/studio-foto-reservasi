<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AdminController;
use App\Models\ServicePackage;
use App\Models\Gallery;
use App\Models\Faq;

// --- PUBLIC ROUTES ---
Route::get('/', function () {
    $packages = ServicePackage::take(3)->get();
    $galleries = Gallery::latest()->take(6)->get();
    return view('home', compact('packages', 'galleries'));
})->name('home');

Route::get('/profil', function () {
    return view('profil');
})->name('profil');

Route::get('/paket', function () {
    $packages = ServicePackage::all();
    return view('paket', compact('packages'));
})->name('paket');

Route::get('/galeri', function () {
    $galleries = Gallery::all();
    return view('galeri', compact('galleries'));
})->name('galeri');

Route::get('/informasi', function () {
    return view('informasi');
})->name('informasi');

// Redirect lama /faq ke /informasi agar tidak 404
Route::redirect('/faq', '/informasi');

// Redirect lama /kontak ke /informasi karena kontak sudah digabung di halaman informasi
Route::redirect('/kontak', '/informasi')->name('kontak');

// --- RESERVATION ---
Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
Route::get('/reservasi/sukses', [ReservationController::class, 'success'])->name('reservasi.success');

// --- CHATBOT ---
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot/chat', [ChatbotController::class, 'handle'])->name('chatbot.chat');

// --- ADMIN SIDE (With Auth Middleware) ---
Route::prefix('admin')->group(function () {
    // Login routes (Manual for simplicity if Auth not scaffolded)
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        
        // Reservasi
        Route::get('/reservasi', [AdminController::class, 'reservations'])->name('admin.reservations');
        Route::get('/reservasi/{reservation}/edit', [AdminController::class, 'editReservation'])->name('admin.reservations.edit');
        Route::patch('/reservasi/{reservation}/status', [AdminController::class, 'updateReservationStatus'])->name('admin.reservations.status');
        Route::delete('/reservasi/{reservation}', [AdminController::class, 'destroyReservation'])->name('admin.reservations.destroy');

        // Paket
        Route::get('/packages', [AdminController::class, 'packages'])->name('admin.packages');
        Route::get('/packages/create', [AdminController::class, 'createPackage'])->name('admin.packages.create');
        Route::post('/packages', [AdminController::class, 'storePackage'])->name('admin.packages.store');
        Route::get('/packages/{package}/edit', [AdminController::class, 'editPackage'])->name('admin.packages.edit');
        Route::put('/packages/{package}', [AdminController::class, 'updatePackage'])->name('admin.packages.update');
        Route::delete('/packages/{package}', [AdminController::class, 'deletePackage'])->name('admin.packages.destroy');
        
        // FAQ
        Route::get('/faqs', [AdminController::class, 'faqs'])->name('admin.faqs');
        Route::post('/faqs', [AdminController::class, 'storeFaq'])->name('admin.faqs.store');
        Route::get('/faqs/{faq}/edit', [AdminController::class, 'editFaq'])->name('admin.faqs.edit');
        Route::put('/faqs/{faq}', [AdminController::class, 'updateFaq'])->name('admin.faqs.update');
        Route::delete('/faqs/{faq}', [AdminController::class, 'deleteFaq'])->name('admin.faqs.destroy');

        // Galeri
        Route::get('/galleries', [AdminController::class, 'galleries'])->name('admin.galleries');
        Route::post('/galleries', [AdminController::class, 'storeGallery'])->name('admin.galleries.store');
        Route::delete('/galleries/{gallery}', [AdminController::class, 'deleteGallery'])->name('admin.galleries.destroy');
    });
});
