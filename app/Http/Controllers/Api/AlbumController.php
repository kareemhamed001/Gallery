<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Album\DeleteAlbumRequest;
use App\Http\Requests\Album\SearchAlbumRequest;
use App\Http\Requests\Album\StoreAlbumRequest;
use App\Http\Requests\Album\UpdateAlbumRequest;
use App\Models\Album;
use App\Traits\ApiResponse;
use App\Traits\ImagesOperations;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    use ApiResponse, ImagesOperations;

    function index()
    {
        try {
            $albums = Album::query()->get();
            return $this->apiResponse($albums, $this->SUCCESS_MESSAGE, $this->SUCCESS_CODE);
        } catch (\Throwable $e) {
            return $this->apiResponse(null, $e->getMessage(), 500);
        }
    }

    function store(StoreAlbumRequest $request)
    {
        try {
            $cover_image = $this->storeFile($request->cover, $this->ALBUM_COVER_PATH);
            $album = Album::query()->create([
                'name' => $request->name,
                'cover' => $cover_image
            ]);
            return $this->apiResponse($album, $this->SUCCESS_MESSAGE, $this->SUCCESS_CODE);
        } catch (\Throwable $e) {
            return $this->apiResponse(null, $e->getMessage(), 500);
        }
    }

    function update(UpdateAlbumRequest $request, $id)
    {
        try {
            $album = Album::query()->find($id);
            if (!$album) {
                return $this->apiResponse(null, $this->NOT_FOUND_ERROR_MESSAGE, $this->NOT_FOUND_ERROR_CODE);
            }
            $album->name = $request->name ?? $album->name;
            if ($request->cover) {
                $cover_image = $this->storeFile($request->cover, $this->ALBUM_COVER_PATH);
                $this->deleteFile($album->cover);
                $album->cover = $cover_image;
            }
            $album->update();
            return $this->apiResponse($album, 'success', 200);
        } catch (\Throwable $e) {
            return $this->apiResponse(null, $e->getMessage(), 500);
        }
    }

    function destroy(DeleteAlbumRequest $request, $id)
    {

        try {
            $album = Album::query()->find($id);
            if (!$album) {
                return $this->apiResponse(null, 'Album You Want To Delete Not Found', $this->NOT_FOUND_ERROR_CODE);
            }
            if ($request->move_to) {
                if ($album->id == $request->move_to) {
                    return $this->apiResponse(null, 'you must select another album to move images to', 400);
                }
                $albumMoveTo = Album::query()->find($request->move_to);
                if (!$albumMoveTo) {
                    return $this->apiResponse(null, 'Album You Want To Move To Not Found', $this->NOT_FOUND_ERROR_CODE);
                }

                $album->images()->update([
                    'album_id' => $albumMoveTo->id
                ]);

            } else {
                $album->images()->delete();
            }

            $this->deleteFile($album->cover, $this->ALBUM_COVER_PATH);
            $album->delete();
            return $this->apiResponse(null, $this->SUCCESS_MESSAGE, $this->SUCCESS_CODE);
        } catch (\Throwable $e) {
            return $this->apiResponse(null, $e->getMessage(), 500);
        }

    }

    function show($id)
    {
        try {
            $album = Album::query()->find($id);
            return $this->apiResponse($album, $this->SUCCESS_MESSAGE, $this->SUCCESS_CODE);
        } catch (\Throwable $e) {
            return $this->apiResponse(null, $e->getMessage(), 500);
        }
    }

    function search(SearchAlbumRequest $request){
        try {
            $albums = Album::query()->where('name','like','%'.$request->search.'%')->get();
            return $this->apiResponse($albums, $this->SUCCESS_MESSAGE, $this->SUCCESS_CODE);
        } catch (\Throwable $e) {
            return $this->apiResponse(null, $e->getMessage(), 500);
        }
    }
}
