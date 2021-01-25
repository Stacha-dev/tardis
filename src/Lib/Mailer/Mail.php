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

    /** @var Headers */
    private $headers;


    /**
     * @param string $to
     * @param string $subject
     * @param string $content
     */
    public function __construct(string $to, string $subject, string $content)
    {
        $this->headers = new Headers();
        $this->setTo($to);
        $this->setSubject($subject);
        $this->setContent($content);
    }


    /**
     * Set Recipient's email
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
     * Set Sender's email
     *
     * @param string $from
     * @param string $fromName
     * @return self
     */
    public function setFrom(string $fromName, string $from): self
    {
        if (Text::isEmail($from)) {
            $this->headers->setFrom($fromName, $from);
        } else {
            throw new Exception('Sender\'s E-mail is Not Valid', 400);
        }
        return $this;
    }


    /**
     * Set Subject
     *
     * @param string $subject
     * @return self
     */
    public function setSubject(string $subject): self
    {
        if (Text::hasMax(78, $subject)) {
            $this->subject = $subject;
        } else {
            throw new Exception('Subject text is longer than 78 characters', 400);
        }
        return $this;
    }


    /**
     * Set Content
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
        if (mail($this->to, $this->subject, $this->content, $this->headers->getHeaders())) {
            return true;
        } else {
            throw new Exception('E-mail has Not been sent!', 400);
        }
    }
}
