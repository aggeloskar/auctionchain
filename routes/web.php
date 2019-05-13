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

Route::get('/', 'ItemController@homeshow');

Route::get('auctions', function(){
    return view('auctions');
});

Route::get('new-auction', function(){
    return view('newauction');
})->middleware('auth');

Route::get('about', function(){
    return view('about');
});

Route::get('myauctions', 'ItemController@myauctions')->middleware('auth');

Route::get('pastauctions', 'ItemController@past')->middleware('auth');

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::resource('items', 'ItemController')->middleware('auth');

Route::get('profile', 'HomeController@profile')->name('profile')->middleware('auth');

Route::post('newauction', 'ItemController@store');

Route::post('items/placebid', 'ItemController@placebid');

Route::get('/items/{itemid}/pay', [
    'middleware' => 'CheckUser::class',
    'uses' => 'ItemController@pay'
]);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
