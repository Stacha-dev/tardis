<?php
declare(strict_types = 1);
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

	/**
	 * Return user ID.
	 *
	 * @return integer
	 */
    public function getId()
    {
        return $this->id;
    }

	/**
	 * Returns user name.
	 *
	 * @return string
	 */
    public function getName()
    {
        return $this->name;
    }

	/**
	 * Sets user name.
	 *
	 * @param string $name
	 * @return void
	 */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}
