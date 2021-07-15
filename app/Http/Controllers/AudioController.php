<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audio;
class AudioController extends Controller
{
    public function getAudioByComicId($id){
        return Audio::where('comic_id', $id)->get();
    }
}
