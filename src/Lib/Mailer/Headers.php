<?php

declare(strict_types=1);

namespace App\Lib\Mailer;

class Headers
{
    /** @var array<string|array> */
    private $headers;


    public function __construct()
    {
        $this->setHeader('Bcc', [])
             ->setHeader('Content-Type', 'text/html; charset=utf-8')
             ->setHeader('X-Mailer', 'PHP/' . phpversion());
    }


    /**
     * Set single header
     *
     * @param string $key
     * @param mixed $content
     * @return self
     */
    private function setHeader(string $key, $content): self
    {
        $this->headers[$key] = $content;
        return $this;
    }

    
    /**
     * Get single header
     *
     * @param string $key
     * @return mixed
     */
    public function getHeader(string $key)
    {
        return $this->headers[$key];
    }


    /**
     * Return string header for email
     *
     * @return array<array|string>
     */
    public function getHeaders(): array
    {
        foreach ($this->headers as &$header) {
            if (is_array($header)) {
                $header = implode(' ,', $header);
            }
        }
        return $this->headers;
    }


    /**
     * Adds Bcc to headders
     *
     * @param string $bcc
     * @return self
     */
    public function addBcc(string $bcc): self
    {
        $bccHeader = $this->getHeader('Bcc');
        if (is_array($bccHeader)) {
            array_push($bccHeader, $bcc);
            $this->setHeader('Bcc', $bccHeader);
        }
        return $this;
    }


    /**
     * Adds From to headders
     *
     * @param string $from
     * @param string $fromName
     * @return void
     */
    public function setFrom(string $fromName, string $from): void
    {
        $this->setHeader('From', $fromName . ' <' . $from . '>');
    }
}
