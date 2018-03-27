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
// New Dog
Route::get('/dogs/new', 'DogsController@getNewDog');
Route::post('/post-new-dog', 'DogsController@postNewDog');

// Get All Dogs
Route::get('/dogs', 'DogsController@getAllDogs');

// Dog Image
Route::post('/update-dog-image', 'DogsController@updateDogImage');

// Dog Overview
Route::get('/dogs/overview/{id}', [
    'as' => 'dogs.overview', 
    'uses' => 'DogsController@dogOverview'
]);

// Dog Profile
Route::get('/dogs/profile/{id}', [
    'as' => 'dogs.profile', 
    'uses' => 'DogsController@dogProfile'
]);
Route::post('/save-profile', 'DogsController@saveDogProfile');

// Dog Health
Route::get('/dogs/health/{id}', [
    'as' => 'dogs.health_records', 
    'uses' => 'DogsController@dogHealth'
]);
Route::get('/dogs/health/new/{id}', [
    'as' => 'dogs.health_new', 
    'uses' => 'DogsController@newDogHealth'
]);
Route::post('/new-health-record', 'DogsController@createHealthRecord');


//Dog Grooming
Route::get('/dogs/grooming/{id}', [
    'as' => 'dogs.grooming',
    'uses' => 'DogsController@dogGrooming'
]);
Route::get('/dogs/grooming/new/{id}', [
    'as' => 'dogs.grooming_new',
    'uses' => 'DogsController@newDogGrooming'
]);
Route::post('/new-grooming-record', 'DogsController@createGroomingRecord');

//Dog Exercise
Route::get('/dogs/exercise/{id}', [
    'as' => 'dogs.exercise_records',
    'uses' => 'DogsController@dogExercise'
]);
Route::get('/dogs/exercise/new/{id}', [
    'as' => 'dogs.exercise_new',
    'uses' => 'DogsController@newDogExercise'
]);
Route::post('/new-exercise-record', 'DogsController@createExerciseRecord');

//Abnormalities
Route::get('dogs/abnormalities/{id}', [
    'as' => 'dogs.abnormalities',
    'uses' => 'DogsController@dogAbnormalities'
]);


