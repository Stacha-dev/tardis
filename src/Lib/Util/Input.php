<?php

declare(strict_types=1);

namespace App\Lib\Util;

/**
 * String tools library.
 */
class Input
{
    /**
     * Converts input string to ASCII.
     *
     * @param  string $input
     * @return string
     */
    public static function toAscii(string $input): string
    {
        $input = preg_replace('#[^\x09\x0A\x0D\x20-\x7E\xA0-\x{2FF}\x{370}-\x{10FFFF}]#u', '', $input) ?? "";
        $input = strtr($input, '`\'"^~', "\x01\x02\x03\x04\x05");
        $input = (string)iconv('UTF-8', 'ASCII//TRANSLIT', $input);
        $input = strtr(
            $input,
            "\xa5\xa3\xbc\x8c\xa7\x8a\xaa\x8d\x8f\x8e\xaf\xb9\xb3\xbe\x9c\x9a\xba\x9d\x9f\x9e"
                . "\xbf\xc0\xc1\xc2\xc3\xc4\xc5\xc6\xc7\xc8\xc9\xca\xcb\xcc\xcd\xce\xcf\xd0\xd1\xd2\xd3"
                . "\xd4\xd5\xd6\xd7\xd8\xd9\xda\xdb\xdc\xdd\xde\xdf\xe0\xe1\xe2\xe3\xe4\xe5\xe6\xe7\xe8"
                . "\xe9\xea\xeb\xec\xed\xee\xef\xf0\xf1\xf2\xf3\xf4\xf5\xf6\xf8\xf9\xfa\xfb\xfc\xfd\xfe\x96",
            "ALLSSSSTZZZallssstzzzRAAAALCCCEEEEIIDDNNOOOOxRUUUUYTsraaaalccceeeeiiddnnooooruuuuyt-"
        );
        $input = str_replace(array('`', "'", '"', '^', '~'), '', $input);
        return (string)strtr($input, "\x01\x02\x03\x04\x05", '`\'"^~');
    }

    /**
     * Converts input string to url like string.
     *
     * @param  string $input
     * @return string
     */
    public static function toAlias(string $input): string
    {
        $input = self::toAscii($input);
        $input = preg_replace('/[^A-Za-z0-9-]+/', '-', $input) ?? "";
        return strtolower(trim($input));
    }
}
