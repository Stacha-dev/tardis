<?php
declare(strict_types = 1);
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\Column(type="string", length=191, unique=true)
     * @var string
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $surname;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @ORM\Version
     * @var \DateTime
     */
    protected $updated;

    /**
     * @ORM\Column(type="string", length=1024)
     * @var string
     */
    protected $avatar;

    /**
     * @ORM\OneToMany(targetEntity="Access", mappedBy="user")
     */
    protected $access;

    public function __construct(string $username = "", string $password = "", string $email = "", string $name = "", string $surname = "", string $avatar = "")
    {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setEmail($email);
        $this->setName($name);
        $this->setSurname($surname);
        $this->setAvatar($avatar);
        $this->access = new ArrayCollection();
    }

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
     * Sets user username.
     *
     * @param  string $username
     * @return void
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * Returns user username.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Sets user password.
     *
     * @param  string $password
     * @return void
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * Returns user password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Sets user e-mail.
     *
     * @param  string $email
     * @return void
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Returns user e-mail.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Sets user name.
     *
     * @param  string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
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
     * Sets user surname.
     *
     * @param  string $surname
     * @return void
     */
    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }

    /**
     * Returns user surname.
     *
     * @return string
     */
    public function getSurname():string
    {
        return $this->surname;
    }

    /**
     * Sets user updated date.
     *
     * @param  \DateTime $updated
     * @return void
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
    }

    /**
     * Returns user updated date.
     *
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * Sets user avatar.
     *
     * @param  string $avatar
     * @return void
     */
    public function setAvatar(string $avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * Returns user avatar.
     *
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
    * Returns user access.
    *
    * @return \Doctrine\ORM\PersistentCollection
    */
    public function getAccess(): \Doctrine\ORM\PersistentCollection
    {
        return $this->access;
    }
}
