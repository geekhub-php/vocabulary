<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Translate
 *
 * @ORM\Table(name="translate")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TranslateRepository")
 */
class Translate
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
     * @ORM\Column(name="ukrainian", type="string", length=255)
     */
    private $ukrainian;

    /**
     * @var string
     *
     * @ORM\Column(name="russian", type="string", length=255)
     */
    private $russian;

    /**
     * @var string
     *
     * @ORM\Column(name="german", type="string", length=255)
     */
    private $german;

    /**
     * @var string
     *
     * @ORM\Column(name="italian", type="string", length=255)
     */
    private $italian;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Word", mappedBy="translate")
     */
    private $word;

    /**
     * @return mixed
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param mixed $word
     */
    public function setWord($word)
    {
        $this->word = $word;
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
     * Set ukrainian
     *
     * @param string $ukrainian
     *
     * @return Translate
     */
    public function setUkrainian($ukrainian)
    {
        $this->ukrainian = $ukrainian;

        return $this;
    }

    /**
     * Get ukrainian
     *
     * @return string
     */
    public function getUkrainian()
    {
        return $this->ukrainian;
    }

    /**
     * Set russian
     *
     * @param string $russian
     *
     * @return Translate
     */
    public function setRussian($russian)
    {
        $this->russian = $russian;

        return $this;
    }

    /**
     * Get russian
     *
     * @return string
     */
    public function getRussian()
    {
        return $this->russian;
    }

    /**
     * Set german
     *
     * @param string $german
     *
     * @return Translate
     */
    public function setGerman($german)
    {
        $this->german = $german;

        return $this;
    }

    /**
     * Get german
     *
     * @return string
     */
    public function getGerman()
    {
        return $this->german;
    }

    /**
     * Set italian
     *
     * @param string $italian
     *
     * @return Translate
     */
    public function setItalian($italian)
    {
        $this->italian = $italian;

        return $this;
    }

    /**
     * Get italian
     *
     * @return string
     */
    public function getItalian()
    {
        return $this->italian;
    }
}
