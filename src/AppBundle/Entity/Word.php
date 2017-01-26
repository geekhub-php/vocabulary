<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Word
 *
 * @ORM\Table(name="word")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WordRepository")
 */
class Word
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
     * @ORM\Column(type="string", length=255, unique=true)
     *
     */
    private $text;

    /**
     * @var ArrayCollection
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Translate", inversedBy="word", cascade={"persist", "remove"})
     */
    private $translate;


    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="words")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->translate = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }


    /**
     * @return mixed
     */
    public function getTranslate()
    {
        return $this->translate;
    }

    /**
     * @param mixed $translate
     */
    public function setTranslate($translate)
    {
        $this->translate = $translate;
    }


    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
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
     * Set text
     *
     * @param string $text
     *
     * @return Word
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
