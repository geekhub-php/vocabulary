<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Word
 *
 * @ORM\Table(name="word")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WordRepository")
 */
class Word extends BaseSuperClass
{
    use ORMBehaviors\Translatable\Translatable;

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
     * @Assert\Valid
     */
    protected $translations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->wishlists = new \Doctrine\Common\Collections\ArrayCollection();
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
