<?php

Route::get('/home', function () {
    return redirect('/borrow/books');
})->name('home');

