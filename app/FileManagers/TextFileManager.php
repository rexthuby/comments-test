<?php

namespace App\FileManagers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

class TextFileManager extends BaseFileManager
{
   protected string $path = '/text';
}
