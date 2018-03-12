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


/*
|--------------------------------------------------------------------------
| Authentication Routing
|--------------------------------------------------------------------------
*/
Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');





/*
|--------------------------------------------------------------------------
| Dashboard – Home
|--------------------------------------------------------------------------
*/
Route::get('/home', function () {
    return view('home');
});





/*
|--------------------------------------------------------------------------
| Dashboard – Dogs
|--------------------------------------------------------------------------
*/
// Get All Dogs
Route::get('/dogs', 'DogsController@getAllDogs');

// Edit Dog
Route::get('/dogs/edit/{id}', [
    'as' => 'dogs.edit', 
    'uses' => 'DogsController@editDog'
]);

// New Dog
Route::get('/dogs/new', 'DogsController@getNewDog');
Route::post('/post-new-dog', 'DogsController@postNewDog');
