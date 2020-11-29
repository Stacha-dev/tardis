<?php
declare(strict_types = 1);
namespace App\View;

use App\View\BaseView;

class Error extends BaseView
{
    /**
     * Rednder error.
     *
     * @param  string  $message
     * @param  integer $code
     * @return void
     */
    public static function render(string $message = "", int $code = 400)
    {
        $message = array("state" => "err", "detail" => $message);
        echo json_encode($message);
        http_response_code($code);
    }
}
