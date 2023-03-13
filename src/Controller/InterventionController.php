<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Form\InterventionType;
use App\Repository\ClientRepository;
use App\Repository\InterventionRepository;
use App\Repository\TechnicienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/intervention')]
class InterventionController extends AbstractController
{
    #[Route('/', name: 'app_intervention_index', methods: ['GET'])]
    public function index(InterventionRepository $interventionRepository): Response
    {
        // On va chercher la requête
        $interventionAll = $interventionRepository->findIntervention();

        //dd($interventionAll);

        //dd($interventionCount);

        return $this->render('intervention/index.html.twig', [
            'interventions' => $interventionAll, //On prend la requête et on la met dans intervention
        ]);


    }

    #[Route('/new', name: 'app_intervention_new', methods: ['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $entityManager,ClientRepository $clientRepository, TechnicienRepository $technicienRepository): Response
    {

        //Nouveau travailleur
        $intervention = new Intervention();
        $client       = $clientRepository->findAll(); //On trouve toutes les clients
        $technicien   = $technicienRepository->findAll(); //On trouve tous les techniciens


        if ($request->request->get("intervention")) { //Si la requête est bonne alors:

            //On affecte à intervention l'id du client et l'id tech
            $intervention->setIdClient($request->request->get("intervention")["id_client"]);
            $intervention->setIdTechnicien($request->request->get("intervention")["id_technicien"]);
            $dateIntervention = new \DateTime($request->request->get("intervention")["date"]);
            $intervention->setCp($request->request->get("intervention")["cp"]);
            $intervention->setAdresse($request->request->get("intervention")["adresse"]);
            $intervention->setPrix($request->request->get("intervention")["prix"]);
            $intervention->setVille($request->request->get("intervention")["ville"]);
            $intervention->setDate($dateIntervention);

            if ($intervention->getIdClient() && $intervention->getIdTechnicien() &&  $intervention->getVille() &&  $intervention->getAdresse() &&  $intervention->getPrix() &&  $intervention->getCp() && $intervention->getDate()) {

                //On persiste l'objet en base
                $entityManager->persist($intervention);
                //Le flush permet de confirmer le tout
                $entityManager->flush();

                return $this->redirectToRoute('intervention/index.html.twig', [], Response::HTTP_SEE_OTHER);

            }
        }

        //dd($technicien);

        return $this->render('intervention/new.html.twig', [
            'intervention' => $intervention,
            //Type clés index ce qui nous permet apres de jouer avec notamment avec les selects dans les formulaires manuels
            'clients' => $client,
            'techniciens' => $technicien,
        ]);
    }

    #[Route('/{id}', name: 'app_intervention_show', methods: ['GET'])]
    public function show(Intervention $intervention,ClientRepository $clientRepository, TechnicienRepository $technicienRepository): Response
    {

        $client = $clientRepository->findOneBy(['id'=>$intervention->getIdClient()]);

        // Pour le afficher en plus de detail
        // Permet de rechercher via l'id Tech et client de chaque ligne le nom correspondant
        // A rajouter dans TEMPLATE/SHOW.html
        $technicien = $technicienRepository->findOneBy(['id'=>$intervention->getIdTechnicien()]);

        //dd($region);
        return $this->render('intervention/show.html.twig', [
            'intervention' => $intervention,
            'client' => $client,
            'technicien' => $technicien
        ]);
    }

    #[Route('/{id}/edit', name: 'app_intervention_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Intervention $intervention, InterventionRepository $interventionRepository): Response
    {

    }

    #[Route('/{id}', name: 'app_intervention_delete', methods: ['POST'])]
    public function delete(Request $request, Intervention $intervention, InterventionRepository $interventionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$intervention->getId(), $request->request->get('_token'))) {
            $interventionRepository->remove($intervention, true);
        }

        return $this->redirectToRoute('app_intervention_index', [], Response::HTTP_SEE_OTHER);
    }
}
