<?php

namespace App\Generators;

use App\Services\FileService;

class BaseGenerator
{
    public function rollbackFile($path, $fileName)
    {
        if (file_exists($path . $fileName)) {
            return FileService::deleteFile($path, $fileName);
        }
        return false;
    }
}
