<?php

namespace AppBundle\Services;

use AppBundle\Entity\Word;

class DataBaseManager
{
    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function save($object)
    {
        $this->em->persist($object);
        $this->em->flush();
    }

    public function saveWord($data, Word $word = null)
    {
        if ($word === null) {
            $word = new Word();
        }
        $word->translate('en')->setName($data['english']);
        $word->translate('fr')->setName($data['french']);
        $word->translate('ru')->setName($data['russian']);
        $word->translate('de')->setName($data['german']);
        $word->translate('uk')->setName($data['ukrainian']);
        $this->em->persist($word);
        $word->mergeNewTranslations();
        $this->em->flush();
    }

    public function update()
    {
        $this->em->flush();
    }

    public function delete($object)
    {
        $this->em->remove($object);
        $this->em->flush();
    }
}
