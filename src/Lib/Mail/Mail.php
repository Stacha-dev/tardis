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
     */
    public function __construct(string $to, string $from, string $fromName, string $content)
    {
        $this->to = $to;
        $this->from = $from;
        $this->fromName = $fromName;
        $this->content = $content;
    }


    /**
    * Add hidden copy
    *
    * @return void
    */
    public static function addBcc($bcc):void
    {
        $this->bcc = $bcc;
    }


    /**
    * Add reply to (different adress)
    *
    * @return void
    */
    public static function addReplyTo($replyTo, $replyToName):void
    {
        $this->replyTo = $replyTo;
        $this->replyToName = $replyToName;
    }


    /**
    * Send mail
    *
    * @return bool
    */
    public static function send():bool
    {

        $headders .= 'From: '.$fromName.' <'.$from.'>'."\r\n";

        if (isset($this->bcc)) {
            $headders .= 'Bcc: '.$bcc."\r\n";
        }

        if (isset($this->replyTo) && isset($this->replyToName)) {
            $headders .= 'Reply-To: '.$this->replyToName.' <'.$this->replyTo.'>'."\r\n";
        }

        $headders .= 'Content-Type: text/html; charset=utf-8'."\r\n".
                     'X-Mailer: PHP/'.phpversion();
        
        return mail($this->to, $this->from, $this->content, $headders);
    }

}