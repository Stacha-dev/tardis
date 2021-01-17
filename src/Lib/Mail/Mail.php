<?php
declare(strict_types = 1);

namespace App\Lib\Mail;

class Mail
{

    /** @var string */
    private $headders;


    /**
     *
     * @param string $to
     * @param string $from
     * @param string $fromName
     * @param string $content
     */
    public function __construct(string $to, string $from, string $fromName, string $subject, string $content)
    {
        $this->to = $to?$to:false;
        $this->from = testEmail($from, 'From')?$from:false;
        $this->fromName = $fromName?$fromName:false;
        $this->subject = $subject?$subject:false;
        $this->content = $content?$content:false;

    }


    /**
    * Add hidden copy
    *
    * @return void
    */
    public static function addBcc($bcc):void
    {
        $this->bcc = testEmail($bcc, 'Bcc')?$bcc:false;
    }


    /**
    * Add reply to (different address)
    *
    * @return void
    */
    public static function addReplyTo($replyTo, $replyToName):void
    {
        $this->replyTo = testEmail($replyTo, 'Reply-to')?$replyTo:false;
        $this->replyToName = $replyToName;
    }


    /**
     * Test for email address
     * 
     * @return bool
     */
    private static function testEmail(string $email, string $case):bool
    {
        if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
            throw new Exception('Not valid "'.$case.'" email address!');
        }
    }


    /**
    * Send mail
    *
    * @return bool
    */
    public static function send():bool
    {
        if ($this->from && $this->fromName) {
            $headders .= 'From: '.$this->fromName.' <'.$this->from.'>'."\r\n";
        }

        if ($this->bcc) {
            $headders .= 'Bcc: '.$bcc."\r\n";
        }

        if ($this->replyTo && $this->replyToName) {
            $headders .= 'Reply-To: '.$this->replyToName.' <'.$this->replyTo.'>'."\r\n";
        }

        $headders .= 'Content-Type: text/html; charset=utf-8'."\r\n".
                     'X-Mailer: PHP/'.phpversion();

        if ($this->to && $this->subject && $this->content) {

            if (mail($this->to, $this->subject, $this->content, $headders)) {
                return true;
            } else {                
                throw new Exception('Mail has not been sent!');
            }

        } else {
            throw new Exception('Input has not met Requied Parameters!');
        }
        
    }

}