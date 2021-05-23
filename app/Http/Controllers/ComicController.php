<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;

class ComicController extends Controller
{
    public function getComics(){
        $comicCollection = Comic::all();
        foreach ($comicCollection as $comic) {
            $comic['genre'] = $comic->genre;
        }
        return $comicCollection;
    }
    public function getComicById($id){
        return Comic::where('id', $id)->with('genre')->get();
    }
}
