<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Lib\FileSystem\File;

final class FileTest extends TestCase
{
    /** @var string */
    private const DOCUMENT_ROOT = __DIR__ . "/../../..";

    private const FILENAME = "test_file";

    /** @var string */
    private const FILE_PATH = self::DOCUMENT_ROOT . "/public/storage/" . self::FILENAME . ".pdf";

    public function setUp(): void
    {
        fopen(self::FILE_PATH, 'w');
    }

    public function tearDown():void
    {
        @unlink(self::FILE_PATH);
    }

    /**
     * Test is successful if file can be opened
     *
     * @return void
     */
    public function testFileCanBeOpened():void
    {
        $file = new File(self::FILE_PATH);
        $this->assertInstanceOf("App\Lib\FileSystem\File", $file);
    }

    /**
     * Test is successful if file exists
     *
     * @return void
     */
    public function testFileExists():void
    {
        $file = new File(self::FILE_PATH);
        $this->assertFileExists($file->getPath());
    }

    /**
     * Test is successfull if filename is returned
     *
     * @return void
     */
    public function testFileNameIsReturned():void
    {
        $file = new File(self::FILE_PATH);
        $this->assertSame(self::FILENAME, $file->getFilename());
    }

    /**
     * Test is successfull if file is not image
     *
     * @return void
     */
    public function testFileIsImage():void
    {
        $file = new File(self::FILE_PATH);
        $this->assertFalse($file->isImage());
    }

    /**
     * Test is successfull if file is not turned to image
     *
     * @return void
     */
    public function testFileToImage():void
    {
        $file = new File(self::FILE_PATH);
        $this->expectException("Exception");
        $image = $file->toImage();
    }

    /**
     * Test is successfull if file is deleted
     *
     * @return void
     */
    public function testFileCanBeDeleted():void
    {
        $file = new File(self::FILE_PATH);
        $file->delete();
        $this->assertFileNotExists($file->getPath());
    }

    /**
     * Test is successfull if file is renamed
     *
     * @return void
     */
    public function testFileCanBeRenamed():void
    {
        $file = new File(self::FILE_PATH);
        $file->rename("new_name");
        $this->assertFileExists($file->getPath());
        $file->delete();
    }

    /**
     * Test is successfull if file is moved
     *
     * @return void
     */
    public function testFileCanBeMoved():void
    {
        $file = new File(self::FILE_PATH);
        $file->move(self::DOCUMENT_ROOT . "/public/storage/test.pdf");
        $this->assertFileExists($file->getPath());
        $file->delete();
    }
}
