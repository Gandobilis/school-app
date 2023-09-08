<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    public function fileUpload($file, $storagePath = 'imgs')
    {
        $originalTitle = $file->getClientOriginalName();
        $newName = time() . '_' . $originalTitle;
        $filePath = $file->storeAs($storagePath, $newName, 'public');

        return [
            'title' => $originalTitle,
            'path' => $filePath
        ];
    }

    public function deleteFile($path)
    {
        if (Storage::exists($path)) {
            return Storage::delete($path);
        }
    }
}
