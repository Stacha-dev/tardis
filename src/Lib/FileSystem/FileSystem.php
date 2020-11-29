<?php
declare(strict_types = 1);
namespace App\Lib\FileSystem;

use App\Lib\FileSystem\File;
use App\Lib\FileSystem\Image;
use App\Lib\Util\Cryptography;

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
     * Returns web url to file
     *
     * @param File|Image $file
     * @return string
     */
    public static function getUrl($file):string
    {
        $host = isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : "pc.stacha.dev";
        return "https://" . $host . DIRECTORY_SEPARATOR .  self::STORAGE_NAME . DIRECTORY_SEPARATOR . $file->getBasename();
    }
}
