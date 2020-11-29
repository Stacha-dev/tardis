<?php
declare(strict_types = 1);
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
    protected $path;

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
    protected $standing;

    /**
     * @ORM\Column(type="boolean")
     * @var                       boolean
     */
    protected $status;

    /**
     * @param string $title
     * @param bool $status
     */
    public function __construct(Gallery $gallery, string $title = "", string $path, int $standing = 0, bool $status = true)
    {
        $this->setGallery($gallery);
        $this->setTitle($title);
        $this->setPath($path);
        $this->setStanding($standing);
        $this->setStatus($status);
    }

    /**
     * Sets image gallery
     *
     * @param Gallery $gallery
     * @return void
     */
    public function setGallery(Gallery $gallery):void
    {
        $this->gallery = $gallery;
    }


    /**
     * Sets image title
     *
     * @param  string $title
     * @return void
     */
    public function setTitle(string $title):void
    {
        $this->title = $title;
    }

    /**
     * Sets path to image
     *
     * @param string $path
     * @return void
     */
    public function setPath(string $path):void
    {
        $this->path = $path;
    }

    /**
     * Sets image standing
     *
     * @param integer $standing
     * @return void
     */
    public function setStanding(int $standing):void
    {
        $this->standing = $standing;
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
     * Sets image status
     *
     * @param boolean $status
     * @return void
     */
    public function setStatus(bool $status):void
    {
        $this->status = $status;
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
    public function getGallery():Gallery
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
     * Returns image path
     *
     * @return string
     */
    public function getPath():string
    {
        return $this->path;
    }

    /**
     * Returns image standing
     *
     * @return integer
     */
    public function getStanding():int
    {
        return $this->standing;
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
     * Returns image status
     *
     * @return boolean
     */
    public function getStatus():bool
    {
        return $this->status;
    }
}
