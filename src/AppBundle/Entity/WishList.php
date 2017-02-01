<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Word.
 *
 * @ORM\Table(name="wish_list")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WishListRepository")
 */
class WishList
{
    use Timestampable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var object
     * @Assert\Type("object")
     * @Assert\Valid
     * @ORM\OneToOne(targetEntity="User", inversedBy="wish_list")
     */
    private $user;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Word", inversedBy="wish_lists")
     */
    private $words;

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
     * Set user.
     *
     * @param object User
     *
     * @return WishList
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param Word $word
     *
     * @return $this
     */
    public function addWord(Word $word)
    {
        if (!$this->words->contains($word)) {
            $this->words->add($word);
            $word->addWishList($this);
        }

        return $this;
    }

    /**
     * Get words.
     *
     * @return ArrayCollection
     */
    public function getWords()
    {
        return $this->words;
    }
}
