<?php
declare(strict_types = 1);
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true, length=191)
     * @var	string
     */
    protected $title;

    /**
     * @param string $title
     */
    public function __construct(string $title = "")
    {
        $this->setTitle($title);
    }

    /**
     * Set tag title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title):void
    {
        $this->title = $title;
    }

    /**
     * Return tag title
     *
     * @return string
     */
    public function getTitle():string
    {
        return $this->title;
    }
}
