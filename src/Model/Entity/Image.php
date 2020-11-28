<?php
declare(strict_types = 1);
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=512)
     * @var                       string
     */
    protected $title;

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
     * @ORM\Column(type="integer")
     * @var                        int
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="Gallery")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id")
     * @var int
     */
    private $gallery;

    /**
     * @param string $title
     * @param bool $status
     */
    public function __construct(string $title = "", bool $status = true)
    {
        $this->setTitle($title);
        $this->setStatus($status);
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
     * Returns image title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets image title
     *
     * @param  string $title
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
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
     * Returns image updated date
     *
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
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
     * Returns image status
     *
     * @return boolean
     */
    public function getStatus():bool
    {
        return $this->status;
    }

    /**
     * Sets image gallery ID
     *
     * @param integer $gallery_id
     * @return void
     */
    public function setGallery(int $gallery_id):void
    {
        $this->gallery = $gallery_id;
    }

    /**
     * Returns gallery ID
     *
     * @return integer
     */
    public function getGallery():int
    {
        return $this->gallery;
    }
}
