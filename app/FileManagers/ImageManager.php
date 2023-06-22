<?php

namespace App\FileManagers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as interventionImage;

class ImageManager extends BaseFileManager
{
    protected string $path = '/images';

    public function save(UploadedFile $file): string
    {
        $dimension = $file->dimensions();
        $dimensionX = $dimension[0];
        $dimensionY = $dimension[1];
        if ($dimensionX > 320 || $dimensionY > 240) {
            $image = $file;
            $newFileName = hash("sha256", rand()) . '.' . $image->getClientOriginalExtension();
            $fullSavePathToDir = storage_path('app/public'.$this->path);
            if (!File::isDirectory($fullSavePathToDir)) {
                File::makeDirectory($fullSavePathToDir, 0777, true, true);
            }

            $interventionImage = interventionImage::make($image->getRealPath());
            $interventionImage->resize(320, 240, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($fullSavePathToDir . '/' . $newFileName);

            $dirName = $this->path;
            if (strpos($this->path,'/')===0){
                $dirName = substr($this->path,1);
            }

            return $dirName.'/'.$newFileName;
        }
        return parent::save($file);
    }
}
