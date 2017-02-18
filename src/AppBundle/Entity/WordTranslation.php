<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WordTranslation
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WordRepository")
 */
class WordTranslation
{
    use ORMBehaviors\Translatable\Translation;

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
     * Set word
     *
     * @param string $word
     *
     * @return WordTranslation
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
}
