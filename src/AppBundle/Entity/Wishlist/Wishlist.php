<?php

namespace AppBundle\Entity\Wishlist;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User\User;
use AppBundle\Entity\Word\Word;

/**
 * Wishlist
 *
 * @ORM\Table(name="wishlist_wishlist")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Wishlist\WishlistRepository")
 */
class Wishlist
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
     * @var \stdClass
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User\User", mappedBy="wishlist", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Word\Word")
     */
    private $words;

    public function __construct()
    {
        $this->words = new \Doctrine\Common\Collections\ArrayCollection();

    }

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
     * Set user
     *
     * @param \stdClass $user
     *
     * @return Wishlist
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add word.
     *
     * @param \AppBundle\Entity\Word\Word $word
     *
     * @return Word
     */
    public function addWord(\AppBundle\Entity\Word\Word $word)
    {
        $this->words[] = $word;

        return $this;
    }

    /**
     * Remove word.
     *
     * @param \AppBundle\Entity\Word\Word $word
     */
    public function removeWord(\AppBundle\Entity\Word\Word $word)
    {
        $this->words->removeElement($word);
    }


    /**
     * Add words.
     *
     * @param \AppBundle\Entity\Word\Word $words
     *
     * @return Words
     */
    public function setWords($words)
    {
        $this->words= $words;

        return $this;
    }


    /**
     * Get words
     *
     * @return array
     */
    public function getWords()
    {
        return $this->words;
    }
}

