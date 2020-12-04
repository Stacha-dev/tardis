<?php
declare(strict_types = 1);
namespace App; // \Lib\Exeption

class EinExeption extends Exeption {

  /** @var string */
  private $message = 'Unknown exeption';

  /** @var int */
  private $code = 0;

  /**
  * @param string $message
  * @param int $code
  */
  public function __construct(string $message, int $code) {

    $this->message = $message;
    $this->code = $code;

  }

  /**
  * Returns message from exeption
  *
  * @return string
  */
  public function getMessage():string {
    return $this->message;
  }

  /**
  * Returns code of exeption from exeption
  *
  * @return int
  */
  public function getCode():int {
    return $this->code;
  }

}
