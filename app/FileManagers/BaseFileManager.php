<?php

namespace App\FileManagers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class BaseFileManager implements FileManagerInterface
{
    protected string $disk = 'public';
    protected string $path = '';

    public function save(UploadedFile $file): string
    {
        $name = Storage::disk($this->disk)->putFile($this->path, $file);
        return $name;
    }

    public function delete(string $fileName): bool
    {
        return Storage::disk($this->disk)->delete($fileName);
    }

    public function exists(string $fileName): bool
    {
        return Storage::disk($this->disk)->fileExists($fileName);
    }

    public function getFullPath(string $fileName): string
    {
        return Storage::disk($this->disk)->url($fileName);
    }
}
