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
    public const PUBLIC_DIRECTORY = 'public';

    /** @var string */
    public const IMAGES_DIRECTORY = 'images';

    /**
     * Open file in file system
     *
     * @param string $path
     * @return File
     */
    public static function open(string $path): File
    {
        return new File(self::isAbsolute($path) ? $path : $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . self::PUBLIC_DIRECTORY . $path);
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

    /**
     * Check if path is absolute
     *
     * @param string $path
     * @return boolean
     */
    public static function isAbsolute(string $path):bool
    {
        return is_int(strpos($path, $_SERVER['HOME']));
    }
}
