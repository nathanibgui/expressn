<?php

namespace App\DataFixtures;

use App\Entity\Labo;
use App\Entity\Region;
use App\Entity\Secteur;
use App\Entity\Travailler;
use App\Entity\User;
use App\Entity\Visiteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DataFixtures extends Fixture
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
        // Secteur
        $secteur = ["NORD","SUD","EST","OUEST","CENTRE"];
        $saveSecteur = [];
        $s = 0;
        foreach ($secteur as $vSecteur)
        {
            $secteur = new Secteur();
            $secteur->setNomSecteur($vSecteur);
            $manager->persist($secteur);
            $manager->flush();
            $saveSecteur[$s] = $secteur->getId();
            $s++;
        }

        $faker = Factory::create('fr_FR');

        // Region
        $saveRegion = [];
        for($e = 0; $e <= 10; $e++) {
            $region = new Region();
            $posSecteur = random_int(0, (count($saveSecteur) - 1));
            $region->setIdSecteur($saveSecteur[$posSecteur]);
            $region->setNomRegion($faker->city());
            $manager->persist($region);
            $manager->flush();
            $saveRegion[$e] = $region->getId();
        }

        // Labo
        $saveLabo = [];
        for($i = 0; $i <= 20; $i++) {
            $labo = new Labo();
            $labo->setNomLabo($faker->company());
            $labo->setChefventeLabo($faker->name());
            $manager->persist($labo);
            $manager->flush();
            $saveLabo[$i] = $labo->getId();
        }

        // Visiteurs
        $saveVisiteur = [];
        for($e = 0; $e <= 30; $e++) {
            $visiteur = new Visiteur();
            $visiteur->setNomVisiteur($faker->firstName());
            $visiteur->setPrenomVisiteur($faker->lastName());
            $visiteur->setAdresseVisiteur($faker->address());
            $visiteur->setCpVisiteur((int) $faker->postcode());
            $visiteur->setVilleVisiteur($faker->city());
            $visiteur->setDateembaucheVisiteur($faker->dateTime);
            $posSecteur = random_int(0, (count($saveSecteur) - 1));
            $visiteur->setIdSecteur($saveSecteur[$posSecteur]);
            $posLabo = random_int(0, (count($saveLabo) - 1));
            $visiteur->setIdLabo($saveLabo[$posLabo]);
            $manager->persist($visiteur);
            $manager->flush();
            $saveVisiteur[$e] = $visiteur->getId();
        }

        //Travailler Jeu de donnée
        for($e = 0; $e <= 50; $e++) {
            $travailler = new Travailler();
            $posRegion = random_int(0, (count($saveRegion) - 1));
            $travailler->setIdRegion($saveRegion[$posRegion]);
            $posVisiteur = random_int(0, (count($saveVisiteur) - 1));
            $travailler->setIdVisiteur($saveVisiteur[$posVisiteur]);
            $travailler->setJjmmaaTravailler($faker->dateTime);
            $travailler->setRoleTravailler($faker->jobTitle());
            $manager->persist($travailler);
            $manager->flush();
        }

    }
}