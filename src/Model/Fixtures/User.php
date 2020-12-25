<?php
declare(strict_types=1);
namespace App\Model\Fixtures;

use App\Model\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserLoader implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager):void
    {
        $user = new User();
        $user->setUsername('root');
        $user->setPassword('');
        $user->setEmail('boys@stacha.dev');
        $user->setName('Stacha');
        $user->setSurname('Stacha');

        $manager->persist($user);
        $manager->flush();
    }
}
