<?php
declare(strict_types = 1);
namespace App\Lib\Mailer;

use Exception;
use App\Lib\Assert\String;
use App\Lib\Mailer\Headers;

class Mail
{

    /** @var string */
    private $to;

    /** @var string */
    private $subject;

    /** @var string */
    private $content;

    /** @var array */
    private $bcc;


    /**
     * @param string $to
     * @param string $subject
     * @param string $content
     */
    public function __construct(string $to, string $subject, string $content)
    {
        $this->to = isEmail($to)?$to:false;
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
            array_push($this->bcc, isEmail($val)?$val:false);
        }
        return $this;
    }


    /**
    * Send mail
    *
    * @return bool
    */
    public function send():bool
    {

        if ($this->to && $this->subject && $this->content) {

            if (mail($this->to, $this->subject, $this->content, setHeaders($this))) {
                return true;
            } else {                
                throw new Exception('E-mail has Not been sent!', 400);
            }

        } else {
            throw new Exception('Input has not met Requied Parameters for Sending E-mail!', 400);
        }
        
    }

}
