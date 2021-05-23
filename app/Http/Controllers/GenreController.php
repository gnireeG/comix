<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Comic;

class GenreController extends Controller
{
    public function getGenres(){
        return Genre::all()->sortBy('title')->values();
    }

    public function getGenreWithComics($genre){
        return Genre::where('title', $genre)->with('comics')->get();
    }
}
