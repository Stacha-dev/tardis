<?php

declare(strict_types=1);

namespace App\Lib\FileSystem;

use Exception;
use App\Lib\FileSystem\FileSystem;
use App\Lib\FileSystem\Image;
use App\Lib\Util\Cryptography;

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

    /** @var string */
    protected $uploadName;

    /** @var array */
    public const MIME_TYPES = ['application/pdf' => 'pdf'];

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        @["dirname" => $this->dirname, "filename" => $this->filename, "extension" => $extension] = pathinfo($path);
        $this->setPath($path);
        $this->setMimeType();
        $this->extension = $extension ?? $this->mimeTypeToExtension($this->mimeType);
    }

    /**
     * Sets file path
     *
     * @param string $path
     * @return self
     */
    protected function setPath(string $path): self
    {
        if (!(file_exists($path))) {
            throw new Exception('File not exists!');
        }
        if (!($realPath = realpath($path))) {
            throw new Exception('File path can not be created!');
        }
        $this->path = $realPath;

        return $this;
    }

    /**
     * Sets mime type
     *
     * @return self
     */
    private function setMimeType(): self
    {
        $mimeType = mime_content_type($this->getPath());
        if (!$mimeType) {
            throw new Exception('Can not read mime type!');
        }

        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Sets file permitions
     *
     * @param integer $permitions
     * @return self
     */
    private function setPermitions(int $permitions): self
    {
        chmod($this->getPath(), $permitions);

        return $this;
    }

    /**
     * Sets upload name
     *
     * @param string $name
     * @return self
     */
    public function setUploadName(string $name): self
    {
        $this->uploadName = $name;

        return $this;
    }

    /**
     * Mime to extension
     *
     * @param string $mime
     * @return string
     */
    private function mimeTypeToExtension(string $mime): string
    {
        if (isset(self::MIME_TYPES[$mime])) {
            return self::MIME_TYPES[$mime];
        } elseif (isset(Image::MIME_TYPES[$mime])) {
            return Image::MIME_TYPES[$mime];
        } else {
            throw new Exception('File is not supported yet!');
        }
    }

    /**
     * Returns filename
     *
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Returns basename
     *
     * @return string
     */
    public function getBasename(): string
    {
        return $this->filename . "." . $this->extension;
    }

    /**
     * Returns path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Returns directory
     *
     * @return string
     */
    public function getDirname(): string
    {
        return $this->dirname;
    }


    /**
     * Returns upload name
     *
     * @return string|null
     */
    public function getUploadName(): ?string
    {
        return $this->uploadName;
    }


    /**
     * Checks if file is image
     *
     * @return boolean
     */
    public function isImage(): bool
    {
        return in_array($this->mimeType, array_keys(Image::MIME_TYPES));
    }

    /**
     * Creates image from file
     *
     * @return Image
     */
    public function toImage(): Image
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
    public function move(string $destination): void
    {
        $destination = is_dir($destination) ? $destination . DIRECTORY_SEPARATOR . $this->getBasename() : $destination;
        rename($this->getPath(), $destination);
        $this->setPath($destination);
        $this->setPermitions(0770);
        ["dirname" => $this->dirname] = pathinfo($this->getPath());
    }

    /**
     * Renames file
     *
     * @param string $filename
     * @return void
     */
    public function rename(string $filename): void
    {
        $newPath = $this->dirname . DIRECTORY_SEPARATOR . $filename . "." . $this->extension;
        rename($this->getPath(), $newPath);
        $this->setPath($newPath);
        $this->filename = $filename;
    }

    /**
     * Copy file to destination
     *
     * @param string $destination
     * @return File
     */
    public function copy(string $destination): File
    {
        if (!copy($this->getPath(), $destination)) {
            throw new Exception('Failed to copy file!', 400);
        }

        return FileSystem::open($destination);
    }

    /**
     * Clone file
     *
     * @return File
     */
    public function clone(): File
    {
        $destination = join('/', [$this->getDirname(), Cryptography::random(6) . '.' . $this->extension]);
        return $this->copy($destination);
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
}
