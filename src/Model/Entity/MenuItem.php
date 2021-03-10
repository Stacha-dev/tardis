<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Entity\Menu;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="menu_item")
 */
class MenuItem
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="items")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id")
     * @var Menu
     */
    protected $menu;

    /**
     * @ORM\Column(type="string", length=512)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=512)
     * @var string
     */
    protected $target;

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
    public function __construct(string $title = "", string $target = "", bool $state = true)
    {
        $this->setTitle($title);
        $this->setTarget($target);
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
     * Sets target
     *
     * @param  string $target
     * @return self
     */
    public function setTarget(string $target): self
    {
        $this->target = $target;
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
     * Returns target
     *
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
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
