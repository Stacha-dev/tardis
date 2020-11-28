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

    public function tearDown():void
    {
        unlink(self::FILE_PATH);
    }

    /**
     * Test is successfull if file can be opened
     *
     * @return void
     */
    public function testFileCanBeOpened():void
    {
        $this->assertInstanceOf("App\Lib\FileSystem\File", FileSystem::open(self::FILE_PATH));
    }

    /**
     * Test is successfull if file exists
     *
     * @return void
     */
    public function testFileExists():void
    {
        $file = FileSystem::open(self::FILE_PATH);
        $this->assertFileExists($file->getPath());
    }

    /**
     * Test is successfull if URL to file is created
     *
     * @return void
     */
    public function testUrlCanBeGenerated():void
    {
        $file = FileSystem::open(self::FILE_PATH);
        $url = FileSystem::getUrl($file);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $this->assertSame(200, $httpcode);
    }
}
