<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlbumController extends Controller
{

    function index(){
        return view('Albums.index');
    }
    function albumView($id){
        return view('Albums.view',compact('id'));
    }
}
