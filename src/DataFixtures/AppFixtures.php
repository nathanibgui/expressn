<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    //methode permettant de hasher le passeword en BDD
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    // fonction pour inserer des données dans la table USER
    //fixtures:load

    public function load(ObjectManager $manager)
    {
        $tabAdmin=['ibguinathan@gmail.com','dantouati@gmail.com','benHayat@gmail.com'];
        foreach ($tabAdmin as $mail) {
            $user = new User();
            $user->setEmail($mail);
            //Ajout de roles
            $user->setRoles(["ROLE_ADMIN"]);


            //ici on hash le passeword "toto"
            $password = $this->hasher->hashPassword($user, 'gsb');
            $user->setPassword($password);

            //on envoie en base de donnée
            $manager->persist($user);
            $manager->flush();
        }
        $tabUser=['nathan@gmail.com','dan@gmail.com','ben@gmail.com'];
        foreach ($tabUser as $mail) {
            $user = new User();
            $user->setEmail($mail);
            //Ajout de roles
            $user->setRoles(["ROLE_USER"]);


            //ici on hash le passeword "toto"
            $password = $this->hasher->hashPassword($user, 'gsb');
            $user->setPassword($password);

            //on envoie en base de donnée
            $manager->persist($user);
            $manager->flush();
        }
    }
}