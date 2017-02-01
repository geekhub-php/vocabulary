<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Word;

class LoadWordData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $word = new Word();
        $word->translate('en')->setName('hello');
        $word->translate('fr')->setName('salut');
        $word->translate('ru')->setName('привет');
        $word->translate('de')->setName('hi');
        $word->translate('uk')->setName('привiт');
        $manager->persist($word);
        $word->mergeNewTranslations();

        $word2 = new Word();
        $word2->translate('en')->setName('good bye');
        $word2->translate('fr')->setName('au revoir');
        $word2->translate('ru')->setName('до свидания');
        $word2->translate('de')->setName('auf Wiedersehen');
        $word2->translate('uk')->setName('до побачення');
        $manager->persist($word2);
        $word2->mergeNewTranslations();

        $word3 = new Word();
        $word3->translate('en')->setName('new');
        $word3->translate('fr')->setName('nouveau');
        $word3->translate('ru')->setName('новый');
        $word3->translate('de')->setName('neue');
        $word3->translate('uk')->setName('новий');
        $manager->persist($word3);
        $word3->mergeNewTranslations();

        $word4 = new Word();
        $word4->translate('en')->setName('old');
        $word4->translate('fr')->setName('le vieux');
        $word4->translate('ru')->setName('старый');
        $word4->translate('de')->setName('alte');
        $word4->translate('uk')->setName('старий');
        $manager->persist($word4);
        $word4->mergeNewTranslations();

        $word5 = new Word();
        $word5->translate('en')->setName('black');
        $word5->translate('fr')->setName('noir');
        $word5->translate('ru')->setName('черный');
        $word5->translate('de')->setName('schwarz');
        $word5->translate('uk')->setName('чорний');
        $manager->persist($word5);
        $word5->mergeNewTranslations();

        $word6 = new Word();
        $word6->translate('en')->setName('white');
        $word6->translate('fr')->setName('blanc');
        $word6->translate('ru')->setName('белый');
        $word6->translate('de')->setName('weiß');
        $word6->translate('uk')->setName('білий');
        $manager->persist($word6);
        $word6->mergeNewTranslations();
        $manager->flush();

        $this->addReference('hello', $word);
    }

    public function getOrder()
    {
        return 1;
    }
}
