<?php

namespace App\FileManagers;

use Illuminate\Http\UploadedFile;

interface FileManagerInterface
{
    public function save(UploadedFile $file): string;

    public function delete(string $fileName): bool;

    public function exists(string $fileName): bool;

    public function getFullPath(string $fileName):string;
}
