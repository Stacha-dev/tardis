<?php

declare(strict_types=1);

namespace App\Lib\Util;

use Exception;


class Timestamp {   
    /**
     * Retruns array from date string
     *
     * @param  string $str
     * @return array<int>
     */
    public static function timestampToArray(string $str): array 
    {
        $ts = explode(' ', $str);
        $date = explode('-', $ts[0]);
        $time = explode(':', $ts[1]);

        if (sizeof($date) == 3 && sizeof($time) == 3 &&
            is_numeric($date[0]) && is_numeric($date[1]) && is_numeric($date[2]) &&
            is_numeric($time[0]) && is_numeric($time[1]) && is_numeric($time[2]) &&
            strlen($date[0]) == 4 && strlen($date[2]) == 2 && strlen($date[2]) == 2 &&
            strlen($date[0]) == 4 && strlen($date[2]) == 2 && strlen($date[2]) == 2) {
                return (array('y' => intval($date[0]), 'm' => intval($date[1]), 'd' => intval($date[2]), 'h' => intval($time[0]), 'i' => intval($time[1]), 's' => intval($time[2])));
        } else {
            throw new Exception('Timestamp is Not in right format YYYY-MM-DD HH:MM:SS', 400);
        }
    }
}