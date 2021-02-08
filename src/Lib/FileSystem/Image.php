<?php

declare(strict_types=1);

namespace App\Lib\FileSystem;

use App\Lib\FileSystem\File;
use App\Lib\FileSystem\FileSystem;
use Imagick;

class Image extends File
{
    /** @var array<string> */
    public const FORMAT = ['WebP' => 'webp', 'JPG' => 'jpg', 'PNG' => 'png'];

    /** @var Imagick */
    public $image;

    /** @var array<string> */
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

    public function __destruct()
    {
        $this->image->clear();
    }

    /**
     * Saves image
     *
     * @return self
     */
    public function save(): self
    {
        $this->image->writeImage($this->getPath());

        return $this;
    }

    /**
     * Saves image as
     *
     * @param string $filename
     * @return self
     */
    public function saveAs(string $filename): self
    {
        $path = join(DIRECTORY_SEPARATOR, [$_SERVER["DOCUMENT_ROOT"], FileSystem::STORAGE, $filename . "." . $this->extension]);
        $this->image->writeImage($path);
        $this->setPath($path);
        ["dirname" => $this->dirname, "filename" => $this->filename] = pathinfo($this->getPath());

        return $this;
    }

    /**
     * Change quality of jpeg
     *
     * @return self
     */
    public function setQuality(int $quality): self
    {
        $this->image->setImageCompressionQuality($quality);
        $this->save();

        return $this;
    }

    /**
     * Sets image format
     *
     * @param string $format
     * @return self
     */
    public function setFormat(string $format): self
    {
        $this->image->setFormat($format);
        $this->save();
        $this->setExtension($format);

        return $this;
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
        $this->image->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1, true);
        $this->save();
    }


    /**
     * Return thumbnail sources
     *
     * @param array<array<int>> $thumbnailDimensions
     * @param string $format
     * @return array<string>
     */
    public function generateThumbnails(array $thumbnailDimensions, string $format = ''): array
    {
        $output = [];
        foreach ($thumbnailDimensions as $dimensions) {
            [$width, $height] = $dimensions;
            $directory = join(DIRECTORY_SEPARATOR, [$this->getDirname(), $width]);
            if (!is_dir($directory)) {
                mkdir($directory, 0770);
            }
            $thumbnail = $this->clone()->toImage();

            $thumbnail->resize($width, $height);
            if ($format) {
                $thumbnail->setFormat($format);
            }

            $thumbnail->move($directory);
            $output[$width] = FileSystem::getUri($thumbnail);
            unset($thumbnail);
        }

        return $output;
    }
}
