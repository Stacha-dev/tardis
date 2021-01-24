<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Entity\Gallery;

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
     * @var                        int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Gallery")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id")
     * @var Gallery
     */
    private $gallery;

    /**
     * @ORM\Column(type="string", length=512)
     * @var                       string
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=512)
     * @var                       string
     */
    protected $source;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @ORM\Version
     * @var                         \DateTime
     */
    protected $updated;

    /**
     * @ORM\Column(type="integer")
     * @var                        int
     */
    protected $ordering;

    /**
     * @ORM\Column(type="boolean")
     * @var                       boolean
     */
    protected $state;

    /**
     * @param Gallery $gallery
     * @param string $title
     * @param array<string> $source
     * @param integer $ordering
     * @param boolean $state
     */
    public function __construct(Gallery $gallery, string $title = "", array $source, int $ordering = 0, bool $state = true)
    {
        $this->setGallery($gallery);
        $this->setTitle($title);
        $this->setSource($source);
        $this->setOrdering($ordering);
        $this->setState($state);
    }

    /**
     * Sets image gallery
     *
     * @param Gallery $gallery
     * @return void
     */
    public function setGallery(Gallery $gallery): void
    {
        $this->gallery = $gallery;
    }


    /**
     * Sets image title
     *
     * @param  string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Sets source to image
     *
     * @param array<string> $source
     * @return void
     */
    public function setSource(array $source): void
    {
        $this->source = json_encode($source, JSON_THROW_ON_ERROR);
    }

    /**
     * Sets image ordering
     *
     * @param integer $ordering
     * @return void
     */
    public function setOrdering(int $ordering): void
    {
        $this->ordering = $ordering;
    }

    /**
     * Sets image updated date
     *
     * @return void
     */
    public function setUpdated()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * Sets image state
     *
     * @param boolean $state
     * @return void
     */
    public function setState(bool $state): void
    {
        $this->state = $state;
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
     * @return array<string>
     */
    public function getSource(): array
    {
        return json_decode($this->source, true);
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
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
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
