<?php

use App\Http\Controllers\ContactController;

Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/services', 'pages.services')->name('services');
Route::view('/consultation', 'pages.consultation')->name('consultation');

Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'show')->name('contact');
    Route::post('/contact', 'submit')->name('contact.submit');
});
