<?php
declare(strict_types = 1);
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Entity\Tag;

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
    * @ORM\ManyToOne(targetEntity="Tag")
    * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
    * @var Tag
    */
    protected $tag;

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
     * Set gallery title
     *
     * @param  string $title
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Set gallery alias
     *
     * @param  string $alias
     * @return void
     */
    public function setAlias(string $alias)
    {
        $this->alias = $alias;
    }

    /**
     * Set gallery tag
     *
     * @param Tag $ag
     * @return void
     */
    public function setTag(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Set gallery updated date
     *
     * @return void
     */
    public function setUpdated()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * Return gallery ID
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Return gallery title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Return gallery alias
     *
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Return gallery tag
     *
     * @return Tag
     */
    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    /**
     * Return gallery updated date
     *
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * Set gallery state
     *
     * @param boolean $state
     * @return void
     */
    public function setState(bool $state):void
    {
        $this->state = $state;
    }

    /**
     * Return gallery state
     *
     * @return boolean
     */
    public function getState():bool
    {
        return $this->state;
    }
}
