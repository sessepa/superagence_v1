<?php

namespace App\DataFixtures;

use App\Entity\Properti;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PropertiesFixtures extends Fixture {

    public function load(ObjectManager $manager): void {
        $propertie = new Properti();
        $propertie->setTitle('Appartement F4');
        $propertie->setDescription('Une petite description');
        $propertie->setSurface(95);
        $propertie->setRooms(5);
        $propertie->setBedrooms(3);
        $propertie->setFloor(3);
        $propertie->setPrice(380000);
        $propertie->setHeat(0);
        $propertie->setAdresse('7 BD Honoré de BALZAC');
        $propertie->setPostalcode('69100');
        $propertie->setCity('Villeurbanne');
        $propertie->setSold(0);

        $manager->persist($propertie);

        //Permet de générer de façon aléatoire des données à la Française
        $faker = Faker\Factory::create('fr_FR');

        // Pour créer par exemple 10 biens, on fait une boucle
        for ($i = 1; $i <= 100; $i++){
            $prop = new Properti();
            $prop->setTitle($faker->words(10,true));         // Renvoie un titre de 10 caractères
            $prop->setDescription($faker->sentences(3,true));  //Renvoie 3 phrases
            $prop->setSurface($faker->numberBetween(30,250));    // Surface entre 30 et 250 mètres carré
            $prop->setRooms($faker->numberBetween(2,8));
            $prop->setBedrooms($faker->numberBetween(1,8));
            $prop->setFloor($faker->numberBetween(0,8));
            $prop->setPrice($faker->numberBetween(90000,500000));
            $prop->setHeat($faker->numberBetween(0,count(Properti::HEAT)-1));
            $prop->setAdresse($faker->streetAddress);
            $prop->setPostalcode(str_replace(' ','',$faker->postcode));
            $prop->setCity($faker->city);
            $prop->setSold($faker->numberBetween(0,1));

            $manager->persist($prop);  //Sauvegarde en mémoire l'ensemble des propriétes initialisées

        }

        $manager->flush();   //Envoie vers la bd

    }
}
