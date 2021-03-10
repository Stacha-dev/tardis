<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use App\Model\Entity\Tag;
use App\Model\Entity\Image;
use DateTime;

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
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=512)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(type="string", unique=true, length=191)
     * @var string
     */
    protected $alias;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="gallery")
     * @ORM\OrderBy({"ordering" = "ASC"})
     * @var PersistentCollection<Image>
     */
    protected $images;

    /**
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * @var Tag
     */
    protected $tag;

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
     * @param string $description
     * @param string $alias
     * @param bool $state
     */
    public function __construct(string $title = "", string $description = "", string $alias = "", bool $state = true)
    {
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setAlias($alias);
        $this->setCreated(new DateTime("now"));
        $this->setState($state);
    }

    /**
     * Sets gallery title
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
     * Sets gallery description
     *
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Sets gallery alias
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
     * Sets gallery tag
     *
     * @param Tag $tag
     * @return self
     */
    public function setTag(Tag $tag): self
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * Sets gallery updated date
     *
     * @return self
     */
    public function setUpdated(): self
    {
        $this->updated = new DateTime("now");
        return $this;
    }

    /**
     * Sets gallery created date
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
     * Sets gallery state
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
     * Return gallery ID
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns images associated to this gallery
     *
     * @return PersistentCollection<Image>
     */
    public function getImages(): PersistentCollection
    {
        return $this->images;
    }

    public function getThumbnail(): ?Image
    {
        return $this->images[0];
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
     * Returns gallery description
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
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
     * Returns gallery tag
     *
     * @return Tag
     */
    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    /**
     * Returns gallery updated date
     *
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * Returns gallery created date
     *
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * Returns gallery state
     *
     * @return boolean
     */
    public function getState(): bool
    {
        return $this->state;
    }
}
