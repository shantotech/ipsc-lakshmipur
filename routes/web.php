<?php

use App\Http\Controllers\PageController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

// The site is bilingual: every public page lives under /bn/... or /en/...
Route::redirect('/', '/'.config('app.locale', 'bn'));

Route::prefix('{locale}')
    ->where(['locale' => 'bn|en'])
    ->middleware(SetLocale::class)
    ->controller(PageController::class)
    ->group(function () {
        Route::get('/', 'home')->name('home');

        // About
        Route::get('about', 'about')->name('about');
        Route::get('about/message/{person}', 'message')->whereIn('person', ['chairman', 'principal'])->name('message');

        // Academic
        Route::get('academic', 'academic')->name('academic');
        Route::get('academic/school-hours', 'schoolHours')->name('school-hours');
        Route::get('academic/uniform', 'uniform')->name('uniform');
        Route::get('academic/calendar', 'calendar')->name('calendar');
        Route::get('facilities', 'facilities')->name('facilities');

        // Administration
        Route::get('administration', 'administration')->name('administration');
        Route::get('administration/rules', 'rules')->name('rules');

        // Admission
        Route::get('admission', 'admission')->name('admission');
        Route::get('admission/apply', 'admissionApply')->name('admission.apply');
        Route::post('admission/apply', 'admissionSubmit')->middleware('throttle:5,1')->name('admission.submit');

        // Notices, gallery, careers, contact
        Route::get('notices', 'notices')->name('notices');
        Route::get('notices/{slug}', 'notice')->name('notices.show');
        Route::get('gallery', 'gallery')->name('gallery');
        Route::get('careers', 'careers')->name('careers');
        Route::get('contact', 'contact')->name('contact');
        Route::post('contact', 'contactSubmit')->middleware('throttle:5,1')->name('contact.submit');
    });
