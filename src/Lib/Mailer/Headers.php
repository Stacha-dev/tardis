<?php

declare(strict_types=1);

namespace App\Lib\Mailer;

class Headers
{
    /** @var string */
    private $headers;

    /** @var string */
    private $bcc;

    /** @var array<string> */
    private array $bccArray;


    /**
     * Return string header for email
     *
     * @return string
     */
    public function getHeaders(): string
    {
        $headers = '';

        if (sizeof($this->bccArray)) {
            $headers .= 'Bcc: ' . implode(', ', $this->bccArray) . "\r\n";
        }

        $headers .= 'Content-Type: text/html; charset=utf-8' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        return $headers;
    }


    /**
     * adds Bcc to headders
     *
     * @param string $bcc
     * @return void
     */
    public function addBcc(string $bcc): void
    {
        array_push($this->bccArray, $bcc);
    }
}
