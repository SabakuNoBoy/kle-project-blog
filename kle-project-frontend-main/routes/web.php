<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\PostDetail;
use App\Livewire\PostCreate;
use App\Livewire\CategoryDetail;
use App\Livewire\AgreementDetail;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\Dashboard;
use App\Services\ApiService;

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');

// Protected routes
Route::middleware(['require.token'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/post/create', PostCreate::class)->name('post.create');
});

// Public routes
Route::get('/', Home::class)->name('home');
Route::get('/post/{slug}', PostDetail::class)->name('post.detail');
Route::get('/category/{slug}', CategoryDetail::class)->name('category.detail');
Route::get('/agreement/{slug}', AgreementDetail::class)->name('agreement.detail');

// Logout route (GET for simple nav link)
Route::get('/logout', function (ApiService $api) {
    if ($api->getToken()) {
        $api->post('logout');
        $api->clearToken();
    }
    return redirect('/');
})->name('logout');

// Offline / Service Unavailable Route
Route::get('/offline', function () {
    return view('errors.service-unavailable');
})->name('offline');

