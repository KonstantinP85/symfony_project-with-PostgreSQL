<?php


namespace App\Services;


use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService implements FileServiceInterface
{
    private $imageDirectory;

    public function __construct($imageDirectory)
    {
        $this->imageDirectory=$imageDirectory;
    }

    /**
     * @return mixed
     */
    public function getImageDirectory()
    {
        return $this->imageDirectory;
    }

    public function imageUpload(UploadedFile $file): string
    {
        $filename = uniqid().'.'.$file->guessExtension();     //имя файла, с расширением загружаемого файла
        try {
            $file->move($this->getImageDirectory(), $filename);
        }
        catch (FileException $exception){
            return  $exception;
        }
        return $filename;
    }

    public function imageRemove(string $filename)
    {
        $fileSystem = new Filesystem();
        $fileImage = $this->getImageDirectory().''.$filename;
        try {
            $fileSystem->remove($fileImage);
        } catch (IOExceptionInterface $exception) {
            echo $exception->getMessage();
        }

    }
}