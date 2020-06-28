<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Controller\Article;
use App\Bootstrap;

final class ArticleTest extends TestCase
{
    private $article;

    /**
     * Test is successfull if instance of App\Controller\Article is created.
     *
     * @return void
     */
    public function testClassConstruct(): void
    {
        $this->assertEmpty($this->article);
        $this->article = new Article(Bootstrap::getEntityManager());
        $this->assertInstanceOf("App\Controller\Article", $this->article);
    }
}
