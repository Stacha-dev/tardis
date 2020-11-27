<?php
declare(strict_types=1);
namespace App\Lib\FileSystem;

use Exception;
use App\Lib\FileSystem\FileSystem;
use App\Lib\FileSystem\Image;

class File
{
    /** @var string */
    protected $path;

    /** @var string */
    protected $dirname;

    /** @var string */
    private $filename;

    /** @var string */
    protected $mimeType;

    /** @var string */
    protected $extension;

    /** @var array */
    public const MIME_TYPES = ['application/pdf' => 'pdf'];

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        @["dirname"=>$this->dirname, "filename"=>$this->filename, "extension"=>$extension]=pathinfo($path);
        $this->setPath($path);
        $this->setMimeType();
        $this->extension = $extension ?? $this->mimeTypeToExtension($this->mimeType);
    }

    /**
     * Sets file path
     *
     * @param string $path
     * @return void
     */
    protected function setPath(string $path):void
    {
        if (!file_exists($path)) {
            throw new Exception('File not exists!');
        }

        $this->path = $path;
    }

    private function setMimeType():void
    {
        $mimeType = mime_content_type($this->getPath());
        if (!$mimeType) {
            throw new Exception('Can not read mime type!');
        }

        $this->mimeType = $mimeType;
    }

    /**
     * Sets file permitions
     *
     * @param integer $permitions
     * @return void
     */
    private function setPermitions(int $permitions):void
    {
        chmod($this->getPath(), $permitions);
    }

    /**
     * Returns filename
     *
     * @return string
     */
    public function getFilename():string
    {
        return $this->filename;
    }

    /**
     * Returns basename
     *
     * @return string
     */
    public function getBasename():string
    {
        return $this->filename . "." . $this->extension;
    }

    /**
     * Returns path
     *
     * @return string
     */
    public function getPath():string
    {
        return $this->path;
    }

    /**
     * Checks if file is image
     *
     * @return boolean
     */
    public function isImage():bool
    {
        return in_array($this->mimeType, array_keys(Image::MIME_TYPES));
    }

    /**
     * Creates image from file
     *
     * @return Image
     */
    public function toImage():Image
    {
        if (!$this->isImage()) {
            throw new Exception('File is not image!');
        }

        return new Image($this->getPath());
    }

    /**
     * Moves file to new location
     *
     * @param string $destination
     * @return void
     */
    public function move(string $destination):void
    {
        rename($this->getPath(), $destination);
        $this->setPath($destination);
        $this->setPermitions(0644);
        ["dirname"=>$this->dirname]=pathinfo($this->getPath());
    }

    /**
     * Renames file
     *
     * @param string $filename
     * @return void
     */
    public function rename(string $filename):void
    {
        $newPath = $this->dirname . DIRECTORY_SEPARATOR . $filename . "." . $this->extension;
        rename($this->getPath(), $newPath);
        $this->setPath($newPath);
        $this->filename=$filename;
    }

    /**
     * Deletes file
     *
     * @return void
     */
    public function delete(): void
    {
        unlink($this->getPath());
    }

    /**
     * Mime to extension
     *
     * @param string $mime
     * @return string
     */
    public function mimeTypeToExtension(string $mime):string
    {
        if (isset(self::MIME_TYPES[$mime])) {
            return self::MIME_TYPES[$mime];
        } elseif (isset(Image::MIME_TYPES[$mime])) {
            return Image::MIME_TYPES[$mime];
        } else {
            throw new Exception('File is not supported yet!');
        }
    }
}
