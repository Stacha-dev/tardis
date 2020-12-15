<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Lib\Util\Input;
use App\Lib\Middleware\RouteFactory;
use Exception;

final class Article extends \App\Controller\Base
{
    /**
     * Register routes to router.
     *
     * @param  \App\Lib\Middleware\Router $router
     * @return void
     */
    public function registerRoutes(\App\Lib\Middleware\Router $router): void
    {
        $router->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9])/article$@", "getAll"))
               ->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9]+)/article/(?<id>[0-9]+)$@", "getOneById", array("id")))
               ->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9]+)/article/(?<alias>[a-z1-9-]+)$@", "getOneByAlias", array("alias")))
               ->register(RouteFactory::fromConstants(1, "POST", "@^(?<version>[0-9]+)/article$@", "create", array(), true))
               ->register(RouteFactory::fromConstants(1, "PUT", "@^(?<version>[0-9]+)/article/(?<id>[0-9]+)$@", "edit", array("id"), true))
               ->register(RouteFactory::fromConstants(1, "DELETE", "@^(?<version>[0-9]+)/article/(?<id>[0-9]+)$@", "delete", array("id"), true));
    }

    /**
     * Gets all articles.
     *
     * @return array<array>
     */
    public function getAll(): array
    {
        $query = $this->entityManager->createQuery('SELECT a FROM App\Model\Entity\Article a');
        $result = $query->getArrayResult();
        $this->view->render($result);
        return $result;
    }

    /**
     * Gets one article by his ID.
     *
     * @param  int $id
     * @return \App\Model\Entity\Article
     */
    public function getOneById(int $id): \App\Model\Entity\Article
    {
        $result = $this->entityManager->getRepository('App\Model\Entity\Article')->findOneBy(array('id'=>$id));
        if ($result instanceof \App\Model\Entity\Article) {
            $this->view->render(array('id' => $result->getId(), 'title' => $result->getTitle(), 'alias' => $result->getAlias(), 'content' => $result->getContent(), 'state' => $result->getState()));
            return $result;
        } else {
            throw new Exception("Article by ID can not be founded!");
        }
    }

    /**
     * Gets one article by his alias.
     *
     * @param  string $alias
     * @return \App\Model\Entity\Article
     */
    public function getOneByAlias(string $alias): \App\Model\Entity\Article
    {
        $result = $this->entityManager->getRepository('App\Model\Entity\Article')->findOneBy(array('alias' => $alias));
        if ($result instanceof \App\Model\Entity\Article) {
            $this->view->render(array('id' => $result->getId(), 'title' => $result->getTitle(), 'content' => $result->getContent()));
            return $result;
        } else {
            throw new Exception("Article by alias can not be founded!");
        }
    }

    /**
     * Creates new article.
     *
     * @param  string $title
     * @param  string $content
     * @return \App\Model\Entity\Article
     */
    public function create(string $title = '', string $alias = null, string $content = ''): \App\Model\Entity\Article
    {
        $body = $this->request->getBody();
        $title = $body->getBodyData('title') ?? $title;
        $alias = $body->getBodyData('alias') ?? $alias ?? Input::toAlias($title);
        $content = $body->getBodyData('content') ?? $content;
        $article = new \App\Model\Entity\Article($title, $alias, $content);
        $this->entityManager->persist($article);
        $this->entityManager->flush();
        $this->view->render(array("id" => $article->getId(), "title" => $article->getTitle(), "alias" => $article->getAlias(), "content" => $article->getContent()));

        return $article;
    }

    /**
     * Edit article by ID.
     *
     * @param  int    $id
     * @param  string $title
     * @param  string $content
     * @return \App\Model\Entity\Article
     */
    public function edit(int $id = 0, string $title = '', string $alias = '', string $content = ''): \App\Model\Entity\Article
    {
        $body = $this->request->getBody();
        $title = $body->getBodyData('title') ?? $title;
        $alias = $body->getBodyData('alias') ?? $alias;
        $content = $body->getBodyData('content') ?? $content;
        $article = $this->entityManager->getRepository('App\Model\Entity\Article')->findOneBy(array('id'=>$id));

        if ($article instanceof \App\Model\Entity\Article) {
            if (!empty($title)) {
                $article->setTitle($title);
            }
            if (!empty($content)) {
                $article->setContent($content);
            }
            if (!empty($alias)) {
                $article->setAlias($alias);
            }
            $this->entityManager->flush();
            $this->view->render(array("id" => $article->getId(), "title" => $article->getTitle(), "alias" => $article->getAlias(), "content" => $article->getContent()));
            return $article;
        } else {
            throw new Exception("Article with ID: " . $id . " not exists!");
        }
    }

    /**
     * Delete article by ID.
     *
     * @param  int $id
     * @return void
     */
    public function delete(int $id = 0)
    {
        $article = $this->entityManager->getRepository('App\Model\Entity\Article')->findOneBy(array('id'=>$id));

        if (isset($article)) {
            $this->entityManager->remove($article);
            $this->entityManager->flush();
        } else {
            throw new Exception("Article with ID: " . $id . " not exists!");
        }
    }
}
