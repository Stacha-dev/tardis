<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="language")
 */
class Language
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
    protected $name;

    /**
     * @ORM\Column(type="string", length=512)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $state;

    /**
     * @param string $name
     * @param string $title
     * @param bool $state
     */
    public function __construct(string $name = "", string $title = "", bool $state = true)
    {
        $this->setName($name);
        $this->setTitle($title);
        $this->setState($state);
    }
    
    /**
     * Sets name
     *
     * @param  string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
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
     * Returns name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * Returns state
     *
     * @return boolean
     */
    public function getState(): bool
    {
        return $this->state;
    }
}
