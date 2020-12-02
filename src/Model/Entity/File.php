<?php
declare(strict_types = 1);
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Entity\Gallery;

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
     * @var                        int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=512)
     * @var                       string
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=512)
     * @var                       string
     */
    protected $path;

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
     * @param bool $state
     */
    public function __construct(string $title = "", string $path, bool $state = true)
    {
        $this->setTitle($title);
        $this->setPath($path);
        $this->setState($state);
    }


    /**
     * Sets file title
     *
     * @param  string $title
     * @return void
     */
    public function setTitle(string $title):void
    {
        $this->title = $title;
    }

    /**
     * Sets path to file
     *
     * @param string $path
     * @return void
     */
    public function setPath(string $path):void
    {
        $this->path = $path;
    }

    /**
     * Sets file updated date
     *
     * @return void
     */
    public function setUpdated()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * Sets file state
     *
     * @param boolean $state
     * @return void
     */
    public function setState(bool $state):void
    {
        $this->state = $state;
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
    public function getPath():string
    {
        return $this->path;
    }


    /**
     * Returns file updated date
     *
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }



    /**
     * Returns file state
     *
     * @return boolean
     */
    public function getState():bool
    {
        return $this->state;
    }
}
