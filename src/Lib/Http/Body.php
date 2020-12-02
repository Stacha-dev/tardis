<?php
declare(strict_types=1);

namespace App\Lib\Http;

use App\Lib\FileSystem\FileSystem;
use Exception;

class Body
{
    /** @var string */
    private $contentType;

    /** @var array<string> */
    private $body;

    /** @var array<\App\Lib\FileSystem\File> */
    private $files = [];

    public function __construct()
    {
        $this->setContentType();
        $this->setBody();
        $this->setFiles();
    }

    /**
     * Parse request body
     */
    private function setBody():void
    {
        switch ($this->contentType) {
            case 'application/json':
                $body = file_get_contents('php://input');
                if (!is_string($body)) {
                    throw new Exception('Body content is not valid!');
                }
                $this->body = json_decode($body, true);
            break;
            case 'multipart/form-data':
                $this->body = $_POST;
            break;
            default:
            $this->body = [];
        break;
        }
    }

    private function setContentType():void
    {
        if (!array_key_exists("CONTENT_TYPE", $_SERVER)) {
            $this->contentType = "";
        } else {
            $contentType = $_SERVER["CONTENT_TYPE"];
            $contentType = explode(";", $contentType);
            $this->contentType = array_shift($contentType);
        }
    }

    private function setFiles():void
    {
        foreach ($_FILES as $key => $file) {
            array_push($this->files, FileSystem::open($file['tmp_name'])->setUploadName($key));
        }
    }

    /**
     * Returns requests body.
     *
     * @return array<string>
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * Returns body data by key.
     *
     * @param  string $key
     * @return string|null
     */
    public function getBodyData(string $key): ?string
    {
        return array_key_exists($key, $this->body) ? $this->body[$key] : null;
    }



    /**
     * Returns body content type
     *
     * @return string
     */
    public function getContentType():string
    {
        return $this->contentType;
    }

    /**
     * Returns files
     *
     * @return array<\App\Lib\FileSystem\File>
     */
    public function getFiles():array
    {
        return $this->files;
    }
}
