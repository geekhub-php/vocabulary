<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Word.
 *
 * @ORM\Table(name="word")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WordRepository")
 */
class Word
{
    use Timestampable;
    use Translatable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="WishList", inversedBy="words")
     */
    private $wish_lists;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @param WishList $wish_list
     *
     * @return $this
     */
    public function addWishList(WishList $wish_list)
    {
        if (!$this->wish_lists->contains($wish_list)) {
            $this->wish_lists->add($wish_list);
            $wish_list->addWord($this);
        }

        return $this;
    }

    /**
     * Get wish_lists.
     *
     * @return ArrayCollection
     */
    public function getWishLists()
    {
        return $this->wish_lists;
    }
}
