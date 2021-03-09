<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

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
     * @var DateTime
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var DateTime
     */
    protected $created;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $state;

    /**
     * Creates new instance of Article class.
     *
     * @param string $title
     * @param string $alias
     * @param string $content
     */
    public function __construct(string $title = "", string $alias = "", string $content = "", bool $state = true)
    {
        $this->setTitle($title);
        $this->setAlias($alias);
        $this->setContent($content);
        $this->setCreated(new DateTime("now"));
        $this->setState($state);
    }

    /**
     * Sets article title.
     *
     * @param  string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Sets article alias.
     *
     * @param  string $alias
     * @return self
     */
    public function setAlias(string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * Sets article content.
     *
     * @param  string $content
     * @return self
     */
    public function setContent(string $content): Self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Sets article updated date.
     *
     * @return self
     */
    public function setUpdated(): self
    {
        $this->updated = new DateTime("now");
        return $this;
    }

    /**
     * Sets article created date
     *
     * @param DateTime $created
     * @return self
     */
    public function setCreated(DateTime $created): self
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Sets article state
     *
     * @param boolean $state
     * @return self
     */
    public function setState(bool $state): self
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Returns article ID.
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns article title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns article alias.
     *
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
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
     * Returns article updated date.
     *
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * Returns article created date
     *
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * Returns article state
     *
     * @return boolean
     */
    public function getState(): bool
    {
        return $this->state;
    }
}
