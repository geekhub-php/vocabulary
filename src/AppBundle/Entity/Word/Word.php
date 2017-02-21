<?php

namespace AppBundle\Entity\Word;

use Doctrine\ORM\Mapping as ORM;
//use Knp\DoctrineBehaviors\ORM as ORMBehaviors;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
//use Knp\DoctrineBehaviors\Model;


/**
 * Word
 *
 * @ORM\Table(name="word_word")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Word\WordRepository")
 */
class Word
{
    //use Model\Translatable\Translatable;

     use Timestampable;
     use Translatable;


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


}

