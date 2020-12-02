<?php
declare(strict_types = 1);
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="gallery")
 */
class Gallery
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var                        int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=512)
     * @var                       string
     */
    protected $title;

    /**
     * @ORM\Column(type="string", unique=true, length=191)
     * @var                       string
     */
    protected $alias;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @ORM\Version
     * @var                         \DateTime
     */
    protected $updated;

    /**
     * @ORM\Column(type="boolean")
     * @var                       boolean
     */
    protected $state;

    /**
     * @param string $title
     * @param string $alias
     */
    public function __construct(string $title = "", string $alias = "", bool $state = true)
    {
        $this->setTitle($title);
        $this->setAlias($alias);
        $this->setState($state);
    }

    /**
     * Returns gallery ID
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns gallery title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets gallery title
     *
     * @param  string $title
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Returns gallery alias
     *
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Sets gallery alias
     *
     * @param  string $alias
     * @return void
     */
    public function setAlias(string $alias)
    {
        $this->alias = $alias;
    }

    /**
     * Sets gallery updated date
     *
     * @return void
     */
    public function setUpdated()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * Returns gallery updated date
     *
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * Sets gallery state
     *
     * @param boolean $state
     * @return void
     */
    public function setState(bool $state):void
    {
        $this->state = $state;
    }

    /**
     * Returns gallery state
     *
     * @return boolean
     */
    public function getState():bool
    {
        return $this->state;
    }
}
