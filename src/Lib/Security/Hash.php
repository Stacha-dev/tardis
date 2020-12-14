<?php
declare(strict_types = 1);
namespace App\Lib\Security;
use App\Lib\Configuration\ConfigurationFactory;

class Hash
{


  /**
  * Gets pepper from global domain config.
  *
  * @return string
  */
    private function getPepper():string
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
  private function hashString(string $str):string
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
          throw new Exeption('Submitted password is too long.', 401);
      }

      // hash user input
      $str = hashString($str);
      $pepper = hashString(getPepper());

      // hash pepper with input together
      return password_hash($pepper.$str, PASSWORD_ARGON2I);

    }


  /**
  * Verify hash from string.
  *
  * @return string
  */
  public static function verifyHash(string $str, string $hash):string
  {
    
    // hash user input
    $str = hashString($str);
    $pepper = hashString(getPepper());

    // hash pepper with input together
    return password_verify($pepper.$str, $hash);
      
  }
}
