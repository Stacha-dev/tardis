<?php

declare(strict_types=1);

namespace App\Lib\Mailer;

use Exception;
use App\Lib\Assert\Text;
use App\Lib\Mailer\Headers;

class Mail
{

    /** @var string */
    private $to;

    /** @var string */
    private $subject;

    /** @var string */
    private $content;

    /** @var string */
    private $bcc;

    /** @var Headers */
    private $headers;


    /**
     * @param string $to
     * @param string $subject
     * @param string $content
     */
    public function __construct(string $to, string $subject, string $content)
    {
        $this->setTo($to);
        $this->setSubject($subject);
        $this->setContent($content);
        $this->headers = new Headers();
    }


    /**
     * set Recipient's email
     *
     * @param string $to
     * @return self
     */
    public function setTo(string $to): self
    {
        if (Text::isEmail($to)) {
            $this->to = $to;
        } else {
            throw new Exception('Recipient\'s E-mail is Not Valid', 400);
        }
        return $this;
    }


    /**
     * set Subject
     *
     * @param string $subject
     * @return self
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }


    /**
     * set Content
     *
     * @param string $content
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }


    /**
     * Add hidden copy
     *
     * @return self
     */
    public function addBcc(string $bcc): self
    {
        if (Text::isEmail($bcc)) {
            $this->headers->addBcc($bcc);
        } else {
            throw new Exception('Bcc E-mail are Not Valid', 400);
        }
        return $this;
    }


    /**
     * Send mail
     *
     * @return bool
     */
    public function send(): bool
    {

        if ($this->to && $this->subject && $this->content) {

            if (mail($this->to, $this->subject, $this->content, $this->headers->getHeaders())) {
                return true;
            } else {
                throw new Exception('E-mail has Not been sent!', 400);
            }
        } else {
            throw new Exception('Input has not met Requied Parameters for Sending E-mail!', 400);
        }
    }
}
