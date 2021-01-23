<?php

declare(strict_types=1);

namespace App\Lib\Mailer;

class Headers
{
    /** @var array<string> */
    private $headers;
    
    /** @var array<string> */
    private $bccArray;


    public function __construct()
    {
        if ($this->bccArray && sizeof($this->bccArray)) {
            $this->headers['Bcc'] = implode(', ', $this->bccArray);
        }

        $this->headers['Content-Type'] = 'text/html; charset=utf-8';
        $this->headers['X-Mailer'] = 'PHP/' . phpversion();
    }


    /**
     * Return string header for email
     *
     * @return array<string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
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


    /**
     * adds From to headders
     *
     * @param string $from
     * @param string $fromName
     * @return void
     */
    public function setFrom(string $fromName, string $from): void
    {
        $this->headers['From'] = $fromName . ' <'. $from . '>';
    }
}
