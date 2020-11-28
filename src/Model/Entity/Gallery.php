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
    protected $status;

    /**
     * @param string $title
     * @param string $alias
     */
    public function __construct(string $title = "", string $alias = "", bool $status = true)
    {
        $this->setTitle($title);
        $this->setAlias($alias);
        $this->setStatus($status);
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
     * Sets gallery status
     *
     * @param boolean $status
     * @return void
     */
    public function setStatus(bool $status):void
    {
        $this->status = $status;
    }

    /**
     * Returns gallery status
     *
     * @return boolean
     */
    public function getStatus():bool
    {
        return $this->status;
    }
}
