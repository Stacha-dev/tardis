<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\FileSystem\FileSystem;

final class FileSystemTest extends TestCase
{
    /** @var string */
    private const DOCUMENT_ROOT = __DIR__ . "/../../..";

    /** @var string */
    private const FILE_PATH = self::DOCUMENT_ROOT . "/public/storage/test_file.jpg";

    public function setUp(): void
    {
        fopen(self::FILE_PATH, 'w');
    }

    public function tearDown(): void
    {
        unlink(self::FILE_PATH);
    }

    /**
     * Test is successful if file can be opened
     *
     * @return void
     */
    public function testFileCanBeOpened()
    {
        $this->assertInstanceOf("App\Lib\FileSystem\File", FileSystem::open(self::FILE_PATH));
    }

    /**
     * Test is successful if file exists
     *
     * @return void
     */
    public function testFileExists()
    {
        $file = FileSystem::open(self::FILE_PATH);
        $this->assertFileExists($file->getPath());
    }
}
