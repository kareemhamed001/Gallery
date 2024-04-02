<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Album\DeleteAlbumRequest;
use App\Http\Requests\Album\StoreAlbumRequest;
use App\Http\Requests\Album\UpdateAlbumRequest;
use App\Http\Requests\Image\DeleteImageRequest;
use App\Http\Requests\Image\StoreImageRequest;
use App\Models\Album;
use App\Models\AlbumImage;
use App\Traits\ApiResponse;
use App\Traits\ImagesOperations;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    use ApiResponse, ImagesOperations;

    function store(StoreImageRequest $request)
    {
        try {
            foreach ($request->images as $image) {
                $cover_image = $this->storeFile($image, $this->ALBUM_IMAGES_PATH);
                AlbumImage::query()->create([
                    'album_id' => $request->album_id,
                    'image' => $cover_image
                ]);
            }


            return $this->apiResponse(null, $this->SUCCESS_MESSAGE, $this->SUCCESS_CODE);
        } catch (\Throwable $e) {
            return $this->apiResponse(null, $e->getMessage(), 500);
        }
    }

    function destroy($id)
    {
        try {
            $image = AlbumImage::query()->find($id);
            if (!$image) {
                return $this->apiResponse(null, 'Image You Want To Delete Not Found', $this->NOT_FOUND_ERROR_CODE);
            }

            $this->deleteFile($image->image, $this->ALBUM_COVER_PATH);
            $image->delete();
            return $this->apiResponse(null, $this->SUCCESS_MESSAGE, $this->SUCCESS_CODE);
        } catch (\Throwable $e) {
            return $this->apiResponse(null, $e->getMessage(), 500);
        }
    }

    function destroyAll(DeleteImageRequest $request)
    {
        try {
            $album = Album::query()->with('images')->find($request->album_id);
            if (!$album) {
                return $this->apiResponse(null, 'Album You Want To Delete Its Not Found', $this->NOT_FOUND_ERROR_CODE);
            }
            foreach ($album->images as $image) {
                $this->deleteFile($image->image, $this->ALBUM_COVER_PATH);
                $image->delete();
            }
            return $this->apiResponse(null, $this->SUCCESS_MESSAGE, $this->SUCCESS_CODE);
        } catch (\Throwable $e) {
            return $this->apiResponse(null, $e->getMessage(), 500);
        }
    }
}
