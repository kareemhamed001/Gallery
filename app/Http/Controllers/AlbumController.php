<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{

    function index()
    {
        return view('Albums.index');
    }

    function show($id)
    {
        try {
            $album = Album::query()->with('images')->findOrFail($id);
            return view('Albums.show', compact('album'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


}
