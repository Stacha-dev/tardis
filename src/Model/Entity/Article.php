<?php
declare(strict_types = 1);
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="article")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
	 * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=512)
	 * @var string
     */
    protected $title;

	/**
	 * @ORM\Column(type="string", unique=true, length=191)
	 * @var string
	 */
	protected $alias;

	/**
     * @ORM\Column(type="string", nullable=true)
	 * @var string
     */
    protected $content;

	 /**
     * @ORM\Column(type="datetime", nullable=false)
	 * @ORM\Version
     * @var \DateTime
     */
    protected $updated;

    /**
     * Creates new instance of Article class.
     *
     * @param string $title
     * @param string $alias
     * @param string $content
     */
    public function __construct(string $title = "", string $alias = "", string $content = ""){
        $this->setTitle($title);
        $this->setAlias($alias);
        $this->setContent($content);
    }

	/**
	 * Returns article ID.
	 *
	 * @return integer
	 */
    public function getId(): int {
        return $this->id;
    }

	/**
	 * Returns article title.
	 *
	 * @return string
	 */
    public function getTitle(): string {
        return $this->title;
    }

	/**
	 * Sets article title.
	 *
	 * @param string $title
	 * @return void
	 */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

	/**
	 * Returns article alias.
	 *
	 * @return string
	 */
    public function getAlias(): string {
        return $this->alias;
    }

	/**
	 * Sets article alias.
	 *
	 * @param string $alias
	 * @return void
	 */
    public function setAlias(string $alias)
    {
        $this->alias = $alias;
    }

	/**
	 * Returns article content.
	 *
	 * @return string
	 */
	public function getContent(): string
    {
        return $this->content;
    }

	/**
	 * Sets article content.
	 *
	 * @param string $content
	 * @return void
	 */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

	 /**
     * Sets user updated date.
     *
     * @return void
     */
    public function setUpdated() {
        $this->updated = new \DateTime("now");
    }

    /**
     * Returns user updated date.
     *
     * @return \DateTime
     */
    public function getUpdated(): \DateTime {
        return $this->updated;
    }
}