<?php

declare(strict_types=1);

namespace App\Lib\FileSystem;

use App\Lib\FileSystem\File;
use App\Lib\FileSystem\FileSystem;
use Imagick;

class Image extends File
{
    /** @var array */
    public const FORMAT = ['WebP' => 'webp', 'JPG' => 'jpg', 'PNG' => 'png'];

    /** @var array */
    public const THUMBNAIL_DIMENSIONS = [[2560, 1440], [1920, 1080], [1366, 768], [1024, 768], [640, 480], [320, 240], [160, 160]];

    /** @var Imagick */
    public $image;

    /** @var array */
    public const MIME_TYPES = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];

    /**
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        parent::__construct($path);
        $this->image = new Imagick($this->getPath());
    }

    /**
     * Saves image
     *
     * @return void
     */
    public function save(): void
    {
        $this->image->writeImage($this->getPath());
    }

    /**
     * Saves image as
     *
     * @param string $filename
     * @return void
     */
    public function saveAs(string $filename): void
    {
        $path = join(DIRECTORY_SEPARATOR, [$_SERVER["DOCUMENT_ROOT"], FileSystem::STORAGE, $filename . "." . $this->extension]);
        $this->image->writeImage($path);
        $this->setPath($path);
        ["dirname" => $this->dirname, "filename" => $this->filename] = pathinfo($this->getPath());
    }

    /**
     * Change quality of jpeg
     *
     * @return void
     */
    public function setQuality(int $quality): void
    {
        $this->image->setImageCompressionQuality($quality);
        $this->save();
    }

    /**
     * Sets image format
     *
     * @param string $format
     * @return void
     */
    public function setFormat(string $format)
    {
        $this->image->setImageFormat($format);
        $this->extension = $format;
    }

    /**
     * Resizes image
     *
     * @param int $width
     * @param int $height
     * @return void
     */
    public function resize(int $width, int $height): void
    {
        $this->image->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 0.5, true);
    }

    /**
     * Deletes image
     *
     * @return void
     */
    public function delete(): void
    {
        unlink($this->getPath());
        foreach (self::THUMBNAIL_DIMENSIONS as $dimension) {
            [$width] = $dimension;
            foreach (self::FORMAT as $format) {
                $path = join(DIRECTORY_SEPARATOR, [$this->getDirname(), $width, $this->getFilename() . "." . $format]);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }
    }

    /**
     * Generates thumbnails
     *
     * @param string $format
     * @return array<string>
     */
    public function generateThumbnails(string $format): array
    {
        $output = [];
        foreach (self::THUMBNAIL_DIMENSIONS as $dimensions) {
            [$width, $height] = $dimensions;
            $directory = join(DIRECTORY_SEPARATOR, [$this->getDirname(), $width]);
            if (!is_dir($directory)) {
                mkdir($directory, 0770);
            }
            $thumbnail = clone $this;
            $thumbnail->resize($width, $height);
            $thumbnail->setFormat($format);
            $thumbnail->saveAs($width . "_" . $this->getFilename());
            $thumbnail->move($directory);
            $output[$width] = FileSystem::getUri($thumbnail);
            unset($thumbnail);
        }

        return $output;
    }
}
