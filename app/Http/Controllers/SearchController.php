<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;

class SearchController extends Controller
{
    public function searchEverything($query_val){
        return Comic::where('title', 'LIKE', "%".$query_val."%")
            ->orWhere('description', 'LIKE', "%".$query_val."%")
            ->orWhere('author', 'LIKE', "%".$query_val."%")->get();
    }
}
