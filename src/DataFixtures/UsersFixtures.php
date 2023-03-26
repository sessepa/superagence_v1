<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder,
                                private SluggerInterface $slugger
    ){}

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('mtoto@demo.fr');
        $admin->setLastname('toto');
        $admin->setFirstname('Marc');
        $admin->setAddress('7 Bd Honore De BALZAC');
        $admin->setZipcode('69100');
        $admin->setCity('Villeurbanne');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin,'admin')
            );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        //Permet de générer des données à la Française
        $faker = Faker\Factory::create('fr_FR');

        // Pour créer par exemple 5 users, on fait une boucle
        for ($usr = 1; $usr <= 5; $usr++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAddress($faker->streetAddress);
            $user->setZipcode(str_replace(' ','',$faker->postcode));
            $user->setCity($faker->city);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user,'user')
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}
