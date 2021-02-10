<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\FileSystem\File;

final class FileTest extends TestCase
{
    /** @var string */
    private const DOCUMENT_ROOT = __DIR__ . "/../../..";

    /** @var string */
    private const SAMPLE_FILENAME = "test_file";

    /** @var string */
    private const SAMPLE_FILE_PATH = self::DOCUMENT_ROOT . "/public/storage/" . self::SAMPLE_FILENAME . ".pdf";

    public function setUp(): void
    {
        fopen(self::SAMPLE_FILE_PATH, 'w');
    }

    public function tearDown(): void
    {
        @unlink(self::SAMPLE_FILE_PATH);
    }

    /**
     * Test is successful if file can be opened
     *
     * @return void
     */
    public function testFileCanBeOpened()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $this->assertInstanceOf("App\Lib\FileSystem\File", $file);
    }

    /**
     * Test is successful if file exists
     *
     * @return void
     */
    public function testFileExists()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $this->assertFileExists($file->getPath());
    }

    /**
     * Test is successfull if filename is returned
     *
     * @return void
     */
    public function testFileNameIsReturned()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $this->assertSame(self::SAMPLE_FILENAME, $file->getFilename());
    }

    /**
     * Test is successfull if file is not image
     *
     * @return void
     */
    public function testFileIsImage()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $this->assertFalse($file->isImage());
    }

    /**
     * Test is successfull if file is not turned to image
     *
     * @return void
     */
    public function testFileToImage()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $this->expectException("Exception");
        $image = $file->toImage();
    }

    /**
     * Test is successfull if file is deleted
     *
     * @return void
     */
    public function testFileCanBeDeleted()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $file->delete();
        $this->assertFileNotExists($file->getPath());
    }

    /**
     * Test is successfull if file is renamed
     *
     * @return void
     */
    public function testFileCanBeRenamed()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $file->rename("new_name");
        $this->assertFileExists($file->getPath());
        $file->delete();
    }

    /**
     * Test is successfull if file is moved
     *
     * @return void
     */
    public function testFileCanBeMoved()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $file->move(self::DOCUMENT_ROOT . "/public/storage/test.pdf");
        $this->assertFileExists($file->getPath());
        $file->delete();
    }

    /**
     * Test is successful if file can be copied
     *
     * @return void
     */
    public function testFileCanBeCopied()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $fileCopy = $file->copy(self::DOCUMENT_ROOT . "/public/storage/copy.pdf");
        $this->assertInstanceOf("\App\Lib\FileSystem\File", $fileCopy);
        $this->assertFileExists($fileCopy->getPath());
        $fileCopy->delete();
    }

    /**
     * TEst is successful if file can be cloned
     *
     * @return void
     */
    public function testFileCanBeCloned()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $fileClone = $file->clone();
        $this->assertInstanceOf("\App\Lib\FileSystem\File", $fileClone);
        $this->assertFileExists($file->getPath());
        $fileClone->delete();
    }

    /**
     * Test is successful if file basename can be returned
     *
     * @return void
     */
    public function testFileBasenameCanBeReturned()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $this->assertEquals(self::SAMPLE_FILENAME . ".pdf", $file->getBasename());
    }

    /**
     * Test is successful if mime type can be returned
     *
     * @return void
     */
    public function testFileMimeTypeCanBeReturned()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $this->assertEquals("application/x-empty", $file->getMimeType());
    }

    /**
     * Test is successful if upload name can be returned
     *
     * @return void
     */
    public function testUploadNameCanBeSetted()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $file->setUploadName("upload_name");
        $this->assertEquals("upload_name", $file->getUploadName());
    }

    /**
     * Test is successful if file to image can not be converted
     *
     * @return void
     */
    public function testFileToImageCanBeConverted()
    {
        $file = new File(self::SAMPLE_FILE_PATH);
        $this->expectException("Exception");
        $image = $file->toImage();
    }
}
