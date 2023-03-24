<?php

namespace App\Controller;

use App\Repository\RealisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AuthenticationUtils $authenticationUtils, RealisationRepository $realisationRepository): Response
    {
        // corresponds au CA de l'annee actue:
        $prixAnnee = $realisationRepository->anneeActuel();

        // corresponds au CA du mois actuel
        $prixMois = $realisationRepository->moisActuel();

        $prixJour = $realisationRepository->jourActuel();

        //dd($prixAnnee);
        //dd($prixMois);

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'prixAnnee' => $prixAnnee,
            'prixMois' => $prixMois,
            'prixJour' => $prixJour,
            'last_username' => $lastUsername
        ]);
    }
}
