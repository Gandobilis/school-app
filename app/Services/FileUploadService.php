<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    public function fileUpload($file, $storagePath = 'imgs')
    {
        $mime = $file->getClientOriginalExtension();
        $originalTitle = $file->getClientOriginalName();

        $newName = Str::random(10) . now() . '.' . $mime;

        $path = $file->storeAs(
            $storagePath,
            $newName,
            'public'
        );

        return [
            'title' => $originalTitle,
            'path' => $path
        ];
    }

    public function deleteFile($path)
    {
        if (Storage::exists($path)) {
            return Storage::delete($path);
        }
    }
}
