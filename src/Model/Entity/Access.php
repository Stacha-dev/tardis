<?php
declare(strict_types = 1);
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="access")
 */
class Access
{
    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    * @var int
    */
    protected $id;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="access")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    * @var \App\Model\Entity\User
    */
    protected $user;

    /**
     * @ORM\Column(type="string", unique=true, length=1024)
     * @var string
     */
    protected $public;

    /**
     * @ORM\Column(type="string", unique=true, length=1024)
     * @var string
     */
    protected $private;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @ORM\Version
     * @var \DateTime
     */
    protected $created;

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
     * Sets users.
     *
     * @param \App\Model\Entity\User $user
     * @return void
     */
    public function setUser(\App\Model\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Returns user.
     *
     * @return \App\Model\Entity\User
     */
    public function getUser(): \App\Model\Entity\User
    {
        return $this->user;
    }

    /**
     * Sets public key.
     *
     * @param string $public
     * @return void
     */
    public function setPublic(string $public)
    {
        $this->public = $public;
    }

    /**
     * Returns public key.
     *
     * @return string
     */
    public function getPublic(): string
    {
        return $this->public;
    }

    /**
     * Sets private key.
     *
     * @param string $private
     * @return void
     */
    public function setPrivate(string $private)
    {
        $this->private = $private;
    }

    /**
     * Returns private key.
     *
     * @return string
     */
    public function getPrivate(): string
    {
        return $this->private;
    }
}
