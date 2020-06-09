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
	 * @return void
	 */
	public function getAll() {
		$query = $this->entityManager->createQuery('SELECT a FROM App\Model\Entity\Article a');
		$result = $query->getArrayResult();
		$this->view->render($result);
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
			$this->view->render(array('title' => $result->getTitle(), 'content' => $result->getContent()));
		} else {
			throw new Exception("The ID has not been defined.");
		}
	}

	/**
	 * Create new article.
	 *
	 * @param array<array> $params
	 * @return void
	 */
	public function create(array $params=[]) {
		$raw = file_get_contents('php://input');
		if(!empty($raw)) {
			$json = json_decode($raw, true);
			if (isset($json['title']) && !empty($json['title'])) {
				$article = new Article();
				$article->setTitle($json['title']);
				$article->setContent(isset($json['content']) ? $json['content'] : NULL);
				$this->entityManager->persist($article);
				$this->entityManager->flush();
			} else {
				throw new Exception('Title is not set!');
			}
		} else {
			throw new Exception('Body is not set!');
		}
	}

	public function delete(array $params=[]) {

	}
}