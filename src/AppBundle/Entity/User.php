<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User.
 *
 * @ORM\Table(name="User")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank(message="site.user.username.notBlank")
     * @Assert\Length(min="5", minMessage="site.user.username.minLength")
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    protected $username;

    /**
     * @var string
     * @Assert\Length(min="8", minMessage="site.user.password.minLength")
     * @Assert\NotBlank(message="site.user.password.notBlank")
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @var ArrayCollection|$words[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Word")
     */
    protected $words;

    /**
     * @ORM\Column(type="string")
     */
    protected $locale = 'en';

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->words = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password.
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
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password) = unserialize($serialized);
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return ArrayCollection
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * @param ArrayCollection $words
     */
    public function setWords($words)
    {
        $this->words[] = $words;
    }

    /**
     * Add word.
     *
     * @param \AppBundle\Entity\Word $word
     *
     * @return User
     */
    public function addWord(Word $word)
    {
        $this->words[] = $word;

        return $this;
    }

    /**
     * Remove word.
     *
     * @param \AppBundle\Entity\Word $word
     */
    public function removeWord(Word $word)
    {
        $this->words->removeElement($word);
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
}
