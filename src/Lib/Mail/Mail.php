<?php
declare(strict_types = 1);

namespace App\Lib\Mailer;

class Mail
{

    /** @var string */
    private $headders;

    /** @var string */
    private $to;

    /** @var string */
    private $from;

    /** @var string */
    private $fromName;

    /** @var string */
    private $subject;

    /** @var string */
    private $content;


    /**
     * @param string $to
     * @param string $from
     * @param string $fromName
     * @param string $content
     */
    public function __construct(string $to, string $from, string $fromName, string $subject, string $content)
    {
        $this->to = $this->assertEmail($to)?$to:false;
        $this->from = $this->assertEmail($from)?$from:false;
        $this->fromName = $fromName?$fromName:false;
        $this->subject = $subject?$subject:false;
        $this->content = $content?$content:false;
    }


    /**
    * Add hidden copy
    *
    * @return void
    */
    public function addBcc(array $bcc):void
    {
        foreach($bcc as &$val) {
            $this->assertEmail($val)?array_push($this->bcc, $val):false;
        }
        return $this;
    }


    /**
     * Test string for email address
     * 
     * @return bool
     */
    private function assertEmail(string $email):bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }


    /**
    * Send mail
    *
    * @return bool
    */
    public function send():bool
    {
        if ($this->from && $this->fromName) {
            $headders .= 'From: '.$this->fromName.' <'.$this->from.'>'."\r\n";
        }

        if ($this->bcc) {
            $headders .= 'Bcc: '.$bcc."\r\n";
        }

        $headders .= 'Content-Type: text/html; charset=utf-8'."\r\n".
                     'X-Mailer: PHP/'.phpversion();

        if ($this->to && $this->subject && $this->content) {

            if (mail($this->to, $this->subject, $this->content, $headders)) {
                return true;
            } else {                
                throw new Exception('E-mail has Not been sent!', 400);
            }

        } else {
            throw new Exception('Input has not met Requied Parameters for Sending E-mail!', 400);
        }
        
    }

}
