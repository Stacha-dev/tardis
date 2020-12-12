<?php
declare(strict_types = 1);
namespace App\Lib\Security; // pak vyuziti bude use App\Lib\Security\Hash;

// use App\Lib\Configuration\ConfigurationFactory;
//$configuration = ConfigurationFactory::fromFileName('common');
//$salt = $configuration->get('jwt_key'); // change to salt_key?

class Hash
{


  /**
  * Creates hash from string.
  *
  * @return string
  */
    public static function getHash(string $str):string
    {
        $salt = 'hellomysalt';

        $res = hash('whirlpool', $salt.$str);

        return $res;
    }
}
