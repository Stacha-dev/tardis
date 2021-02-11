<?php

declare(strict_types=1);

namespace App\View;

class BaseView
{
    public function __construct()
    {
        $this->setResponseHeaders();
    }

    /**
     * Sets response headers by ini file
     *
     * @return void
     */
    private function setResponseHeaders(): void
    {
        $config = parse_ini_file(__DIR__ . "/../../config/api.ini", true);
        if ($config) {
            foreach ($config as $section => $ruleSet) {
                foreach ($ruleSet as $rule => $value) {
                    if (is_array($value)) {
                        $header = $section . "-" . $rule . ": ";
                        foreach ($value as $i => $subValue) {
                            $header .= $i !== array_key_last($value) ? $subValue . "," : $subValue;
                        }
                        header($header);
                    } else {
                        header($section . "-" . $rule . ": " . $value);
                    }
                }
            }
        } else {
            throw new \Exception('Bad config file!');
        }
    }
}
