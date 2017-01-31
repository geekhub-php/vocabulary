<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post
 *
 * @ORM\Table(name="word")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WordRepository")
 */
class Word extends BaseSuperClass
{
    /**
     * @var string
     *
     * @ORM\Column(name="word", type="string", length=150)
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min="3", max="150")
     */
    private $word;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="words")
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Wishlist", mappedBy="words")
     */
    private $wishlists;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->wishlists = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set word
     *
     * @param string $word
     *
     * @return Word
     */
    public function setWord($word)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Word
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add wishlist
     *
     * @param \AppBundle\Entity\Wishlist $wishlist
     *
     * @return Word
     */
    public function addWishlist(\AppBundle\Entity\Wishlist $wishlist)
    {
        if (!$this->wishlists->contains($wishlist)) {
            $this->wishlists[] = $wishlist;
            $wishlist->addWord($this);
        }

        return $this;
    }

    /**
     * Remove wishlist
     *
     * @param \AppBundle\Entity\Wishlist $wishlist
     */
    public function removeWishlist(\AppBundle\Entity\Wishlist $wishlist)
    {
        $this->wishlists->removeElement($wishlist);
    }

    /**
     * Get wishlists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWishlists()
    {
        return $this->wishlists;
    }
}
