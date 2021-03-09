<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="file")
 */
class File
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
     * @ORM\Column(type="string", length=512)
     * @var string
     */
    protected $path;

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
     * @param string $title
     * @param bool $state
     */
    public function __construct(string $title = "", string $path, bool $state = true)
    {
        $this->setTitle($title);
        $this->setPath($path);
        $this->setCreated(new DateTime("now"));
        $this->setState($state);
    }

    /**
     * Sets file title
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
     * Sets path to file
     *
     * @param string $path
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Sets file updated date
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
     * Sets file state
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
     * Returns file ID
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns file title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns file path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Returns file updated date
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
     * Returns file state
     *
     * @return boolean
     */
    public function getState(): bool
    {
        return $this->state;
    }
}
