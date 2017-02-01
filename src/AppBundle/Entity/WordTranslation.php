<?php

namespace AppBundle\Entity;

use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use Doctrine\ORM\Mapping as ORM;

/**
 * WordTranslation.
 *
 * @ORM\Entity
 */
class WordTranslation
{
    use Translation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $spell;

    /**
     * Set spelling.
     *
     * @param string $spell
     */
    public function setName($spell)
    {
        $this->spell = $spell;
    }

    /**
     * Get spelling.
     *
     * @return string
     */
    public function getName()
    {
        return $this->spell;
    }
}
