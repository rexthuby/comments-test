<?php

namespace App\FileManagers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FileManagerFabric implements FabricFileManagerInterface
{
    public function getFabric(string $mimeType): FileManagerInterface
    {
        $imageMimes = ['image/jpeg', 'image/png', 'image/gif'];
        $textMimes = ['text/plain'];
        if (in_array($mimeType, $imageMimes)) {
            /**
             * @var ImageManager $imageManager
             */
            return new ImageManager();
        } elseif (in_array($mimeType, $textMimes)) {
            /**
             * @var TextFileManager $fileManager
             */
            return new TextFileManager();
        }

        /**
         * @var BaseFileManager $baseManager
         */
        Log::warning("File with mime type:$mimeType don't have handler");
        return new BaseFileManager();
    }
}
