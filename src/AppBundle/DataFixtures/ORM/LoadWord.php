<?php
/**
 * Created by PhpStorm.
 * User: xfly3r
 * Date: 14.02.17
 * Time: 13:23
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Language;
use AppBundle\Entity\Word;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class LoadWord implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $engLanguage = new Language();
        $ruLanguage = new Language();
        $ukLanguage = new Language();

        $engLanguage->setName('English')->setValue('en');
        $manager->persist($engLanguage);

        $ruLanguage->setName('Русский')->setValue('ru');
        $manager->persist($ruLanguage);

        $ukLanguage->setName('Українська')->setValue('uk');
        $manager->persist($ukLanguage);

        $faker = Faker::create();

        for ($i = 1; $i <= 1000; $i++)
        {
            $engWord = new Word();
            $ruWord = new Word();
            $ukWord = new Word();

            $word = $faker->word;

            $engName = $word . $i . '_en';
            $engWord->setName($engName);
            $engWord->setLanguage($engLanguage);
            $manager->persist($engWord);

            $ruName = $word . $i . '_ru';
            $ruWord->setName($ruName);
            $ruWord->setLanguage($ruLanguage);
            $manager->persist($ruWord);

            $ukName =  $word . $i . '_ua';
            $ukWord->setName($ukName);
            $ukWord->setLanguage($ukLanguage);
            $manager->persist($ukWord);

            $engWord->addTranslation($ukWord);
            $engWord->addTranslation($ruWord);

            $ruWord->addTranslation($engWord);
            $ruWord->addTranslation($ukWord);

            $ukWord->addTranslation($engWord);
            $ukWord->addTranslation($ruWord);

            $manager->flush();
        }
    }
}