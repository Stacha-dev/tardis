<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Lib\Util\Input;
use Exception;

class User extends \App\Controller\Base
{
    /**
     * Returns all users.
     *
     * @return array<array>
     */
    public function getAll(): array {
        $query = $this->entityManager->createQuery('SELECT u FROM App\Model\Entity\User u');
		$result = $query->getArrayResult();
		$this->view->render($result);
		return $result;
    }

	/**
	 * Creates new user.
	 *
	 * @param string $username
	 * @param string $password
	 * @param string $email
	 * @param string $name
	 * @param string $surname
	 * @param string $avatar
	 * @return \App\Model\Entity\User
	 */
    public function create(string $username = "", string $password = "", string $email = "", string $name = "", string $surname = "", string $avatar = ""): \App\Model\Entity\User {
		$body = $this->request->getBody();
		$username = $body->getBodyData('username') ?? $username;
		$password = $body->getBodyData('password') ?? $password;
		$email = $body->getBodyData('email') ?? $email;
		$name = $body->getBodyData('name') ?? $name;
		$surname = $body->getBodyData('surname') ?? $surname;
		$avatar = $body->getBodyData('avatar') ?? $avatar;
        $user = new \App\Model\Entity\User($username, $password, $email, $name, $surname, $avatar);
		$this->entityManager->persist($user);
		$this->entityManager->flush();
		$this->view->render(array("id" => $user->getId(), "username" => $user->getUsername(), "password" => $user->getPassword(), "email" => $user->getEmail(), "name" => $user->getName(), "surname" => $user->getSurname(), "avatar" => $user->getAvatar()));

		return $user;
    }
}