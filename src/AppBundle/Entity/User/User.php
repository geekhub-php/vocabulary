<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Wishlist\Wishlist;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=100, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Wishlist\Wishlist", inversedBy="user", cascade={"persist", "remove"})
     */
    private $wishlist;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=50)
     */
    private $role;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set wishlist
     *
     * @param string $wishlist
     *
     * @return User
     */
    public function setWishlist($wishlist)
    {
        $this->wishlist = $wishlist;

        return $this;
    }

    /**
     * Get wishlist
     *
     * @return string
     */
    public function getWishlist()
    {
        return $this->wishlist;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }









    public function set($username)
    {
        $this->username = $username;

        return $username;
    }

    public function getRoles()
    {
        return array($this->role);
        // return array('ROLE_ADMIN');
    }

    /*public function getPassword()
    {
    }
    */
    public function getSalt()
    {
    }
    public function eraseCredentials()
    {
    }



}

