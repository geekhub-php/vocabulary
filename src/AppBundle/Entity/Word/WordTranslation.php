<?php

namespace AppBundle\Entity\Word;

use Doctrine\ORM\Mapping as ORM;
//use Knp\DoctrineBehaviors\Model;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;




/**
 * WordTranslation
 *
 * @ORM\Table(name="word_translation_word_translation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WordTranslation\WordTranslationRepository")
 */
class WordTranslation
{
    //use Model\Translatable\Translation;


    use Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;




    /**
     * Set name
     *
     * @param string $name
     *
     * @return WordTranslation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
