<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="menu")
 */
class Menu
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
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="menu")
     * @var PersistentCollection<MenuItem>
     */
    protected $items;

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
    public function __construct(string $title = "", bool $state = true)
    {
        $this->setTitle($title);
        $this->setCreated(new DateTime("now"));
        $this->setState($state);
    }

    /**
     * Sets title
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
     * Sets updated date
     *
     * @return self
     */
    public function setUpdated(): self
    {
        $this->updated = new DateTime("now");
        return $this;
    }

    /**
     * Sets created date
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
     * Sets state
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
     * Return ID
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns menu items associated to menu entity
     *
     * @return PersistentCollection<MenuItem>
     */
    public function getItems(): PersistentCollection
    {
        return $this->items;
    }

    /**
     * Returns updated date
     *
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * Returns created date
     *
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * Returns state
     *
     * @return boolean
     */
    public function getState(): bool
    {
        return $this->state;
    }
}
