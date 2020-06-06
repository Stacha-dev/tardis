<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Controller\BaseController;
use App\Model\Entity\Article;

final class ArticleController extends BaseController
{
	/**
	 * Gets all articles.
	 *
	 * @return void
	 */
	public function getAll() {
		$query = $this->entityManager->createQuery('SELECT a FROM App\Model\Entity\Article a');
		$result = $query->getArrayResult();
		$this->view->display($result);
	}

	/**
	* Gets one article by his ID.
	*
	* @param array<array> $params
	* @return void
	*/
	public function getOne(array $params=[]) {
		foreach($params as $param) {
			if($param['name'] === 'id') {
				$id = $param['value'];
			}
		}
		if(isset($id) && $id) {
			$result = $this->entityManager->find('App\Model\Entity\Article', $id);
			$this->view->display(array('title' => $result->getTitle(), 'content' => $result->getContent()));
		} else {
			throw new InvalidArgumentException("The ID has not been defined.");
		}
	}

	/**
	 * Create new article.
	 *
	 * @param array<array> $params
	 * @return void
	 */
	public function postOne(array $params=[]) {
		foreach($params as $param) {
			if($param['name'] === 'title') {
				$articleTitle = $param['value'];
			}
			if($param['name'] === 'content') {
				$articleContent = $param['value'];
			}
		}
		if (isset($articleTitle) && $articleTitle) {
			$article = new Article();
			$article->setTitle($articleTitle);
			$article->setContent(isset($articleContent) && $articleContent ? $articleContent : NULL);

			$this->entityManager->persist($article);
			$this->entityManager->flush();
		} else {
			return;
		}
	}
}