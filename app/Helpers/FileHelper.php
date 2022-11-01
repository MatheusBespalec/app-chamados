<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FileHelper
{
    /**
     * Transform base64 in instance of UploadedFile
     *
     * @param string $fileData
     * @return UploadedFile
     */
    public static function transformBase64ToFileToUploadedFile(string $fileData): UploadedFile
    {
        $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
        file_put_contents($tmpFilePath, $fileData);

        $tmpFile = new File($tmpFilePath);

        return new UploadedFile(
            $tmpFile->getPathname(),
            $tmpFile->getFilename(),
            $tmpFile->getMimeType(),
            0,
            true
        );
    }
}
