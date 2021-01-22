<?php
declare(strict_types = 1);
namespace App\Lib\Mailer;

class Headers
{
    /** @var string */
    private $headers;

    /**
    * Return string header for email
    *
    * @param string $mail
    * @return self
    */
    public function setHeaders($mail):self
    {

        if ($mail->from && $mail->fromName) {
            $headers .= 'From: '.$mail->fromName.' <'.$mail->from.'>'."\r\n";
        }

        if ($mail->bcc && $bcc = implode(', ', $mail->bcc)) {
            $headers .= 'Bcc: '.$bcc."\r\n";
        }

        $headers .= 'Content-Type: text/html; charset=utf-8'."\r\n".
                    'X-Mailer: PHP/'.phpversion();

        return $headers;

    }

}