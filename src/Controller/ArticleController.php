<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Controller\BaseController;
use App\Model\Entity\Article;
use Exception;

final class ArticleController extends BaseController
{
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
	public function getOne(int $id = -1): \App\Model\Entity\Article {
		$params = $this->request->getUri()->getQuery();
		$id = $params->getQueryParamValue('id') ?? $id;

		$result = $this->entityManager->find('App\Model\Entity\Article', $id);
		if ($result instanceof Article) {
			$this->view->render(array('title' => $result->getTitle(), 'content' => $result->getContent()));
			return $result;
		} else {
			throw new Exception("Article by ID can not be founded!");
		}
	}

	/**
	 * Creates new article.
	 *
	 * @param string $title
	 * @param string $content
	 * @return \App\Model\Entity\Article
	 */
	public function create(string $title = '', string $content = ''): \App\Model\Entity\Article {
		$body = $this->request->getBody();
		$title = $body->getBodyData('title') ?? $title;
		$content = $body->getBodyData('content') ?? $content;
		$article = new Article();
		$article->setTitle($title);
		$article->setContent($content);
		$this->entityManager->persist($article);
		$this->entityManager->flush();
		$this->view->render(array("id" => $article->getId(), "title" => $article->getTitle(), "content" => $article->getContent()));

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
	public function edit(int $id = -1, string $title = '', string $content = ''): \App\Model\Entity\Article {
		$params = $this->request->getUri()->getQuery();
		$body = $this->request->getBody();
		$id = $params->getQueryParamValue('id') ?? $id;
		$title = $body->getBodyData('title') ?? $title;
		$content = $body->getBodyData('content') ?? $content;

		$article = $this->entityManager->find('App\Model\Entity\Article', $id);
		if($article instanceof \App\Model\Entity\Article) {
			if (!empty($title))
				$article->setTitle($title);
			if (!empty($content))
				$article->setContent($content);
			$this->entityManager->flush();
			$this->view->render(array("id" => $article->getId(), "title" => $article->getTitle(), "content" => $article->getContent()));
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