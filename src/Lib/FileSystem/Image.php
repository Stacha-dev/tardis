<?php
declare(strict_types = 1);

namespace App\Lib\FileSystem;

use App\Lib\FileSystem\File;
use App\Lib\FileSystem\FileSystem;
use Imagick;

class Image extends File
{
    /** @var array */
    public const FORMAT = ['WebP' => 'webp', 'JPG' => 'jpg'];

    /** @var array */
    private const THUMBNAIL_DIMENSIONS = [[1024, 768], [640, 480], [320, 240]];

    /** @var Imagick */
    public $image;

    /** @var array */
    public const MIME_TYPES = ['image/jpeg' => 'jpg', 'image/webp' => 'webp'];

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
     * Saves image as
     *
     * @param string $filename
     * @return void
     */
    public function saveAs(string $filename):void
    {
        $path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . FileSystem::STORAGE . DIRECTORY_SEPARATOR . $filename . "." . $this->extension;
        $this->image->writeImage($path);
        $this->setPath($path);
        ["dirname"=>$this->dirname, "filename"=>$this->filename]=pathinfo($this->getPath());
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
        $this->image->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1, true);
    }

    /**
     * Generates thumbnails
     *
     * @return void
     */
    public function generateThumbnails()
    {
        foreach (self::THUMBNAIL_DIMENSIONS as $dimensions) {
            [$width, $height] = $dimensions;
            $thumbnail = clone $this;
            $thumbnail->resize($width, $height);
            $thumbnail->setFormat(self::FORMAT['WebP']);
            $thumbnail->saveAs($width . "_" . $this->getFilename());
            unset($thumbnail);
        }
    }
}
