<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

trait ImagesOperations
{
    public $ALBUM_COVER_PATH = 'albums/covers';
    public $ALBUM_IMAGES_PATH = 'albums/images';
    public function storeFile($file, $path, $disk = 'public')
    {
        try {
            if (is_file($file) && !file_exists(public_path($file)) && !is_string($file)) {
                $path = $file->store($path, ['disk' => $disk]);
                if ($disk == 'public') {
                    return 'storage/' . $path;
                }
                return $path;
            } elseif (file_exists(public_path($file))) {
                return $this->move($file, $path, $disk);
            } elseif (is_string($file)) {
                if (!file_exists(public_path($file))){



                    if (preg_match('/^data:image\/(\w+);base64,/', $file, $matches)) {
                        $imageType = $matches[1];
                    } else {
                       return null;
                    }
                    $imageData = base64_decode( str_replace("data:image/{$imageType};base64,", '', $file));


                    $fileName = Str::uuid() . '.' . $imageType;
                    Storage::disk($disk)->put($path . '/' . $fileName, $imageData);
                    return 'storage/' . $path . '/' . $fileName;
                }
            }
            return $file;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

    public function replaceFile($oldFilePath, $newFile, $newFilePath, $disk = 'public')
    {
        try {

            $path = $this->storeFile($newFile, $newFilePath, $disk);
            if ($path) {
                $oldPath = public_path($oldFilePath);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
                return $path;
            }

            return null;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteFile($filePath, $disk = 'public'): bool
    {
        try {
            $oldPath = public_path($filePath);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteCollectionOfFiles($filesPaths, $disk = 'public')
    {
        try {
            foreach ($filesPaths as $filePath) {
                if (file_exists($filePath)) {
                    unlink(public_path($filePath));
                }
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function move($sourcePath, $destinationPath, $disk = 'public')
    {
        try {

            $fileName = pathinfo($sourcePath, PATHINFO_BASENAME);

            $sourcePath = str_replace('storage/', '', $sourcePath);
            Storage::disk($disk)->move($sourcePath, $destinationPath . '/' . $fileName);
            return 'storage/' . $destinationPath . '/' . $fileName;
        } catch (\Exception $e) {
            return false;
        }
    }

}
