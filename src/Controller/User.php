<?php

declare(strict_types=1);

namespace App\Controller;

use App\Lib\Middleware\RouteFactory;
use App\Lib\Authorization\AuthorizationFactory;
use App\Lib\Security\Hash;
use Exception;

class User extends \App\Controller\Base
{

    /**
     * Register routes to router
     *
     * @param  \App\Lib\Middleware\Router $router
     * @return void
     */
    public function registerRoutes(\App\Lib\Middleware\Router $router): void
    {
        $router->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9])/user$@", "getAll", [], true))
            ->register(RouteFactory::fromConstants(1, "POST", "@^(?<version>[0-9]+)/user$@", "create", [], true))
            ->register(RouteFactory::fromConstants(1, "POST", "@^(?<version>[0-9]+)/user/login$@", "login"))
            ->register(RouteFactory::fromConstants(1, "DELETE", "@^(?<version>[0-9]+)/user/(?<id>[0-9]+)$@", "delete", ["id"], true));
    }

    /**
     * Returns all users
     *
     * @return array<array>
     */
    public function getAll(): array
    {
        $query = $this->entityManager->createQuery('SELECT u FROM App\Model\Entity\User u');
        $result = $query->getArrayResult();
        $this->view->render($result);
        return $result;
    }

    /**
     * Creates new user
     *
     * @return \App\Model\Entity\User
     */
    public function create(): \App\Model\Entity\User
    {
        $body = $this->request->getBody();
        $username = $body->getBodyData('username', '');
        $password = Hash::getHash($body->getBodyData('password', ''));
        $email = $body->getBodyData('email', '');
        $name = $body->getBodyData('name', '');
        $surname = $body->getBodyData('surname', '');
        $avatar = $body->getBodyData('avatar', '');
        $user = new \App\Model\Entity\User($username, $password, $email, $name, $surname, $avatar);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->view->render(array("id" => $user->getId(), "username" => $user->getUsername(), "email" => $user->getEmail(), "name" => $user->getName(), "surname" => $user->getSurname(), "avatar" => $user->getAvatar()));

        return $user;
    }

    /**
     * Verifi user credentials
     *
     * @return \App\Model\Entity\User
     */
    public function login(): \App\Model\Entity\User
    {
        $body = $this->request->getBody();
        $username = $body->getBodyData('username', '');
        $password = $body->getBodyData('password', '');
        $user = $this->entityManager->getRepository('App\Model\Entity\User')->findOneBy(array("username" => $username));
        if ($user instanceof \App\Model\Entity\User) {
            if (Hash::verifyHash($password, $user->getPassword())) {
                $jwt = AuthorizationFactory::fromType('JWT');
                $this->view->render(array("name" => $user->getname(), "surname" => $user->getSurname(), "token" => $jwt->getToken(['id_user' => $user->getId()])));

                return $user;
            } else {
                throw new Exception("Password is incorrect!", 401);
            }
        } else {
            throw new Exception("User not exists!", 401);
        }
    }
}
