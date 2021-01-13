<?php


namespace App\Services;


use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileServiceInterface
{
    /**
     * @param UploadedFile $file
     * @return string
     */
    public function imageUpload(UploadedFile $file): string;

    /**
     * @param string $filename
     * @return mixed
     */
    public function imageRemove(string $filename);

}