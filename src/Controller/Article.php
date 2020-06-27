<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Lib\Util\Input;
use Exception;

final class Article extends \App\Controller\Base
{
	/**
	 * Dispatch request to predefined routes.
	 *
	 * @param \App\Lib\Middleware\Router $router
	 * @param \App\Lib\Http\Request $request
	 * @return void
	 */
	public function requestDispatch(\App\Lib\Middleware\Router $router, \App\Lib\Http\Request $request): void {
		$router->register(array(
			"version" => 1,
			"method" => "GET",
			"pattern" => "@^(?<version>[0-9])/article$@",
			"action" => array("method" => "getAll", "params" => array())));
		$router->register(array(
			"version" => 1,
			"method" => "GET",
			"pattern" => "@^(?<version>[0-9]+)/article/(?<id>[0-9]+)$@",
			"action" => array("method" => "getOneById", "params" => array("id"))));
		$router->register(array(
			"version" => 1,
			"method" => "GET",
			"pattern" => "@^(?<version>[0-9]+)/article/(?<alias>[a-z]+)$@",
			"action" => array("method" => "getOneByAlias", "params" => array("alias"))));
		$router->register(array(
			"version" => 1,
			"method" => "POST",
			"pattern" => "@^(?<version>[0-9]+)/article$@",
			"action" => array("method" => "create", "params" => array())));
		$router->register(array(
			"version" => 1,
			"method" => "PUT",
			"pattern" => "@^(?<version>[0-9]+)/article/(?<id>[0-9]+)$@",
			"action" => array("method" => "edit", "params" => array("id"))));
		$router->register(array(
			"version" => 1,
			"method" => "DELETE",
			"pattern" => "@^(?<version>[0-9]+)/article/(?<id>[0-9]+)$@",
			"action" => array("method" => "delete", "params" => array("id"))));

		$result = $router->dispatch($request);
		if(is_array($result) && array_key_exists("action", $result) && array_key_exists("params", $result)){
			$callback = [$this, $result["action"]];
			if (is_callable($callback)) {
				call_user_func_array($callback, (array)$result["params"]);
			}
		} else {
			throw new Exception("Router problem!");
		}
	}

	/**
	 * Gets all articles.
	 *
	 * @return array<array>
	 */
	public function getAll(): array {
		$query = $this->entityManager->createQuery('SELECT a FROM App\Model\Entity\Article a');
		$result = $query->getArrayResult();
		$this->view->render($result);
		return $result;
	}

	/**
	* Gets one article by his ID.
	*
	* @param int $id
	* @return \App\Model\Entity\Article
	*/
	public function getOneById(int $id): \App\Model\Entity\Article {
		$result = $this->entityManager->find('App\Model\Entity\Article', $id);
		if ($result instanceof \App\Model\Entity\Article) {
			$this->view->render(array('title' => $result->getTitle(), 'content' => $result->getContent()));
			return $result;
		} else {
			throw new Exception("Article by ID can not be founded!");
		}
	}

	/**
	* Gets one article by his alias.
	*
	* @param string $alias
	* @return \App\Model\Entity\Article
	*/
	public function getOneByAlias(string $alias): \App\Model\Entity\Article {
		$params = $this->request->getUri()->getQuery();
		$alias = $params->getQueryParamValue('alias') ?? $alias;

		$result = $this->entityManager->getRepository('App\Model\Entity\Article')->findOneBy(array('alias' => $alias));
		if ($result instanceof \App\Model\Entity\Article) {
			$this->view->render(array('title' => $result->getTitle(), 'content' => $result->getContent()));
			return $result;
		} else {
			throw new Exception("Article by alias can not be founded!");
		}
	}

	/**
	 * Creates new article.
	 *
	 * @param string $title
	 * @param string $content
	 * @return \App\Model\Entity\Article
	 */
	public function create(string $title='', string $alias = NULL, string $content = ''): \App\Model\Entity\Article {
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
	 * @param int $id
	 * @param string $title
	 * @param string $content
	 * @return \App\Model\Entity\Article
	 */
	public function edit(int $id = -1, string $title = '', string $alias= '', string $content = ''): \App\Model\Entity\Article {
		$params = $this->request->getUri()->getQuery();
		$body = $this->request->getBody();
		$id = $params->getQueryParamValue('id') ?? $id;
		$title = $body->getBodyData('title') ?? $title;
		$alias = $body->getBodyData('alias') ?? $alias;
		$content = $body->getBodyData('content') ?? $content;

		$article = $this->entityManager->find('App\Model\Entity\Article', $id);
		if($article instanceof \App\Model\Entity\Article) {
			if (!empty($title))
				$article->setTitle($title);
			if (!empty($content))
				$article->setContent($content);
			if (!empty($alias))
				$article->setContent($alias);
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
	 * @param int $id
	 * @return void
	 */
	public function delete(int $id = -1) {
		$params = $this->request->getUri()->getQuery();
		$id = $params->getQueryParamValue('id') ?? $id;

		$article = $this->entityManager->find('App\Model\Entity\Article', $id);
		if(isset($article)) {
			$this->entityManager->remove($article);
			$this->entityManager->flush();
		} else {
			throw new Exception("Article with ID: " . $id . " not exists!");
		}
	}
}