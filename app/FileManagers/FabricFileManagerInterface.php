<?php

namespace App\FileManagers;

interface FabricFileManagerInterface
{
    /**
     * @param string $mimeType get a factory for working with files of this mimeType
     * @return FileManagerInterface
     */
    public function getFabric(string $mimeType):FileManagerInterface;
}
