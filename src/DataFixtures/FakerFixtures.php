<?php
// src/DataFixtures/FakerFixtures.php
namespace App\DataFixtures;

use Faker;
use App\Entity\Particulier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FakerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 personnes
        for ($i = 0; $i < 10; $i++) {
            $personne = new Particulier();
            $personne->setNom($faker->lastName);
            $personne->setPrenom($faker->firstName);
            $personne->setUsername($faker->name);
            $personne->setEmail($faker->email);
            $manager->persist($personne);
        }

        $manager->flush();
    }
}

