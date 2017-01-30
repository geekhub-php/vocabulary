<?php

namespace AppBundle\Entity\Word;

use Doctrine\ORM\Mapping as ORM;
//use Knp\DoctrineBehaviors\ORM as ORMBehaviors;
use Knp\DoctrineBehaviors\Model;


/**
 * Word
 *
 * @ORM\Table(name="word_word")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Word\WordRepository")
 */
class Word
{
    use Model\Translatable\Translatable;



    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;

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
     * Set name
     *
     * @param string $name
     *
     * @return Word
     */

}

