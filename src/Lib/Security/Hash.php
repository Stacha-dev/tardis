<?php
declare(strict_types = 1);
namespace App\Lib\Security;

use App\Lib\Configuration\ConfigurationFactory;
use Exception;

class Hash
{


  /**
  * Gets pepper from global domain config.
  *
  * @return string
  */
    private static function getPepper():string
    {
        $configuration = ConfigurationFactory::fromFileName('common');
        $configuration->setSegment('security');
        return $configuration->get('pepper');
    }


  /**
  * Basic hash for pepper and password before submit/verify.
  *
  * @return string
  */
  private static function hashString(string $str):string
  {
      return hash('md5', $str);
  }


  /**
  * Creates hash from string.
  *
  * @return string
  */
  public static function getHash(string $str):string
  {

    // check for maximum password length
    if (strlen($str) > 32) {
        throw new Exception('Submitted password is too long.', 401);
    } else {

    // hash user input
    $str = self::hashString($str);
    $pepper = self::hashString(self::getPepper());

    // hash pepper with input together
    $res = password_hash($pepper.$str, PASSWORD_ARGON2I);

    return $res?$res:'';
    }
  }


  /**
  * Verify hash from string.
  *
  * @return bool
  */
  public static function verifyHash(string $str, string $hash):bool
  {

    // hash user input
    $str = self::hashString($str);
    $pepper = self::hashString(self::getPepper());

    // hash pepper with input together
    return password_verify($pepper.$str, $hash);
  }
}
