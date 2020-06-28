<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Lib\Util\Input;

final class InputTest extends TestCase
{
    /**
     * Test is successfull if text is converted to ASCII.
     *
     * @return void
     */
    public function testInputCanBeConvertedToAscii(): void
    {
        $this->assertSame(Input::toAscii("ěščřžýáíé"), "escrzyaie");
    }


    /**
     * Test is successfull if alias from string is returned.
     *
     * @return void
     */
    public function testInputCanBeConvertedToAlias(): void
    {
        $this->assertSame(Input::toAlias("Testovací alias který může reálně nastat 2020 a proto se testuje"), "testovaci-alias-ktery-muze-realne-nastat-2020-a-proto-se-testuje");
    }
}
