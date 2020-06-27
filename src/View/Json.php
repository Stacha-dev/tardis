<?php
declare(strict_types = 1);
namespace App\View;

use App\View\BaseView;
use Exception;

class Json extends BaseView
{
    /**
     * Displays data in JSON format
     *
     * @param  array<integer|string|array> $data
     * @return void
     */
    public function render(array $data): void
    {
        echo json_encode($data);
        if ($error = json_last_error()) {
            throw new Exception(json_last_error_msg());
        }
    }
}
