<?php
declare(strict_types = 1);
namespace App\Lib\FileSystem;

use App\Lib\FileSystem\File;
use App\Lib\FileSystem\Image;
use App\Lib\Util\Cryptography;
use Exception;

class FileSystem
{

    /** @var string */
    public const STORAGE = '/public/storage';

    /** @var string */
    public const STORAGE_NAME = 'storage';

    /** @var string */
    public const IMAGES_DIRECTORY = 'images';

    public static function open(string $path): File
    {
        return new File($path);
    }

    /**
     * Uploads file to web storage
     *
     * @param File $file
     * @return void
     */
    public static function upload(File &$file, string $directory=""):void
    {
        $destination = join("/", [$_SERVER["DOCUMENT_ROOT"] . self::STORAGE, $directory, $file->getBasename()]);
        $file->move($destination);
        $file->rename(Cryptography::random(6));
    }

    /**
    * Returns uri to file
    *
    * @param File|Image $file
    * @return string
    */
    public static function getUri($file):string
    {
        $uri = strstr($file->getPath(), DIRECTORY_SEPARATOR . self::STORAGE_NAME);
        if (!is_string($uri)) {
            throw new Exception('Uri can not be generated!');
        }

        return $uri;
    }
}
