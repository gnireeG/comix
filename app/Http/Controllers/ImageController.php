<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function getImagesByComicId($id){
        return Image::where('comic_id', $id)->get();
    }
}
