<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;


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
    return view('welcome');
});


// TEST

Route::get('/getNavlinks', function(){
    return Response()->json(['hallo', 'test', 'bli', 'blah']);
});

/* Route::get('/getComicGenres', function(){
    return Response()->json([
        ['title' => 'Drama', 'id' => 1],
        ['title' => 'Comedy', 'id' => 2],
        ['title' => 'Thriller', 'id' => 3],
        ['title' => 'Horror', 'id' => 4],
    ]);
}); */

//sleep(2);
Route::get('/getGenres', 'App\Http\Controllers\GenreController@getGenres');
Route::get('/getComics', 'App\Http\Controllers\ComicController@getComics');
Route::get('/getComicById/{id}', 'App\Http\Controllers\ComicController@getComicById');
Route::get('/getImagesByComicId/{id}', 'App\Http\Controllers\ImageController@getImagesByComicId');
Route::get('/getAudioByComicId/{id}', 'App\Http\Controllers\AudioController@getAudioByComicId');
Route::get('/getGenreWithComics/{genre}', 'App\Http\Controllers\GenreController@getGenreWithComics');
Route::get('/searchEverything/{query_val}', 'App\Http\Controllers\SearchController@searchEverything');
