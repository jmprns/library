<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/borrow/login');
})->name('root');

Route::get('/faker', 'FakerController@fake');

Route::group(['prefix' => 'admin'], function () {

  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');

  Route::get('/home', 'Admin\AdminController@home');
  Route::get('/library/add', 'Admin\AdminController@add');
  Route::post('/library/store', 'Admin\AdminController@store');
  Route::get('/library/delete/{id}', 'Admin\AdminController@delete');
  Route::get('/library/reset/{id}', 'Admin\AdminController@reset');
});

Route::group(['prefix' => 'library'], function () {

  Route::get('/', function () {
      return redirect('/library/dashboard');
  });

  Route::get('/blank', 'BlankController@library');

  Route::get('/dashboard', 'Library\DashboardController@index');

  Route::get('/walkin', 'Library\ReservationController@walkin');
  Route::post('/walkin', 'Library\ReservationController@walkinPost');
  Route::get('/walkin/{student}/{id}', 'Library\ReservationController@walkinForm');

  Route::prefix('reservation')->group(function(){

    Route::get('/', 'Library\ReservationController@index');
    Route::get('/view/{id}', 'Library\ReservationController@view');
    Route::post('/approve', 'Library\ReservationController@approve');
    Route::get('/cancel/{id}', 'Library\ReservationController@cancelReservation');
    Route::get('/fetch/{id}', 'Library\ReservationController@fetchReservation');
    Route::get('/lost/{id}', 'Library\ReservationController@lostBook');
    Route::get('/return/{id}', 'Library\ReservationController@return');

    Route::prefix('status')->group(function() {
      Route::get('/{status}', 'Library\ReservationController@status');
    });

    Route::get('/print/{status}', 'Library\ReservationController@print');


  });

  Route::prefix('books')->group(function(){
    Route::get('/', 'Library\BookController@index');
    Route::get('/add', 'Library\BookController@add');
    Route::get('/edit/{id}', 'Library\BookController@edit');
    Route::get('/destroy/{id}', 'Library\BookController@delete');
    Route::post('/store', 'Library\BookController@store');
    Route::post('/update', 'Library\BookController@update');

    Route::get('/catsub/{id}', 'Library\BookController@catsub');

    Route::post('/copy', 'Library\BookController@copy');
    Route::post('/copy/accession', 'Library\BookController@accession');
  });

  Route::prefix('borrow')->group(function(){
    Route::get('/pre', 'Library\BorrowController@index');
    Route::get('/registered', 'Library\BorrowController@list');
    Route::get('/destroy/{id}', 'Library\BorrowController@destroy');
    Route::get('/activate/{id}', 'Library\BorrowController@activate');
  });

  Route::prefix('settings')->group(function(){

    Route::get('/book-category', 'Library\CategoryController@index');
    Route::post('/book-category/store', 'Library\CategoryController@store');
    Route::post('/book-category/update', 'Library\CategoryController@update');
    Route::get('/book-category/destroy/{id}', 'Library\CategoryController@destroy');

    Route::get('/book-subject/{id}', 'Library\SubjectController@index');
    Route::post('/book-subject/store', 'Library\SubjectController@store');
    Route::post('/book-subject/update', 'Library\SubjectController@update');
    Route::get('/book-subject/destroy/{id}', 'Library\SubjectController@destroy');

    Route::get('/profile', 'Library\SettingController@profile');
    Route::post('/profile/information', 'Library\SettingController@info');
    Route::post('/profile/username', 'Library\SettingController@username');
    Route::post('/profile/password', 'Library\SettingController@password');

    Route::get('/logs', 'Library\SettingController@logs');

  });

  Route::get('/login', 'LibraryAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'LibraryAuth\LoginController@login');
  Route::post('/logout', 'LibraryAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'LibraryAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'LibraryAuth\RegisterController@register');

  Route::post('/password/email', 'LibraryAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'LibraryAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'LibraryAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'LibraryAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'borrow'], function () {
  Route::get('/login', 'BorrowAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'BorrowAuth\LoginController@login');
  Route::post('/logout', 'BorrowAuth\LoginController@logout')->name('logout');

  Route::get('/signup', 'BorrowAuth\RegisterController@form');
  Route::post('/signup', 'BorrowAuth\RegisterController@submit');

  
  Route::get('/books', 'Borrow\ReservationController@book');
  Route::get('/books/subject/{id}', 'Borrow\ReservationController@subject');
  Route::post('/books/search/', 'Borrow\ReservationController@search');
  Route::get('/reserve', 'Borrow\ReservationController@list');

  Route::get('/reserve/form/{id}', 'Borrow\ReservationController@form');
  Route::get('/reserve/view/{id}', 'Borrow\ReservationController@view');
  Route::get('/cancel/{id}', 'Borrow\ReservationController@cancel');


  Route::post('/reserve/submit', 'Borrow\ReservationController@reserve');

  Route::prefix('settings')->group(function(){
    Route::get('/', 'Borrow\SettingsController@profile');
    Route::post('/info', 'Borrow\SettingsController@info');
    Route::post('/password', 'Borrow\SettingsController@password');
  });


});
