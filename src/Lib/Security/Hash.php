<?php
declare(strict_types = 1);
namespace App\Lib\Security;

use App\Lib\Configuration\ConfigurationFactory;

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
        $configuration = ConfigurationFactory::fromFileName('common');
        $configuration->setSegment('security');
        $pepper = $configuration->get('pepper');

        $res = hash('whirlpool', $salt.$pepper);

        return $res;
    }
}
