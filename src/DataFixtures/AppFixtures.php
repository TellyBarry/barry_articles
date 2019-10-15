<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("FR-fr");

        for ($i=0; $i < 30 ; $i++) 
        { 
            $libelle = $faker->sentence();
            $image = $faker->imageUrl(1000,350);
            $prix = mt_rand(40,200);
            $article = new Article();
            $article->setLibelle($libelle)
                    ->setPrix($prix)
                    ->setImage($image);
            $manager->persist($article);
        }

        $manager->flush();
    }
}
