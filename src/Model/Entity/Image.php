<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Entity\Gallery;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Gallery", inversedBy="images")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id")
     * @var Gallery
     */
    private $gallery;

    /**
     * @ORM\Column(type="string", length=512)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="json", length=512)
     * @var array<array<string>>
     */
    protected $source;

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
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $ordering;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $state;

    /**
     * @param Gallery $gallery
     * @param string $title
     * @param array<array<string>> $source
     * @param integer $ordering
     * @param boolean $state
     */
    public function __construct(Gallery $gallery, string $title = "", array $source, int $ordering = 0, bool $state = true)
    {
        $this->setGallery($gallery);
        $this->setTitle($title);
        $this->setSource($source);
        $this->setOrdering($ordering);
        $this->setCreated(new DateTime("now"));
        $this->setState($state);
    }

    /**
     * Sets image gallery
     *
     * @param Gallery $gallery
     * @return self
     */
    public function setGallery(Gallery $gallery): self
    {
        $this->gallery = $gallery;
        return $this;
    }

    /**
     * Sets image title
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
     * Sets source to image
     *
     * @param array<array<string>> $source
     * @return self
     */
    public function setSource(array $source): self
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Sets image ordering
     *
     * @param integer $ordering
     * @return self
     */
    public function setOrdering(int $ordering): self
    {
        $this->ordering = $ordering;
        return $this;
    }

    /**
     * Sets image updated date
     *
     * @return self
     */
    public function setUpdated(): self
    {
        $this->updated = new DateTime("now");
        return $this;
    }

    /**
     * Sets image created date
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
     * Sets image state
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
     * Returns image ID
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns image gallery
     *
     * @return Gallery
     */
    public function getGallery(): Gallery
    {
        return $this->gallery;
    }

    /**
     * Returns image title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns image source
     *
     * @return array<array<string>>
     */
    public function getSource(): array
    {
        return $this->source;
    }

    /**
     * Returns image ordering
     *
     * @return integer
     */
    public function getOrdering(): int
    {
        return $this->ordering;
    }

    /**
     * Returns image updated date
     *
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * Returns image created date
     *
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * Returns image state
     *
     * @return boolean
     */
    public function getState(): bool
    {
        return $this->state;
    }
}
