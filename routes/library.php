<?php

Route::get('/home', function () {
    return redirect('/library/dashboard');
})->name('home');

