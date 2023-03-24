<?php

namespace App\Controller;

use App\Entity\Realisation;
use App\Form\RealisationType;
use App\Repository\ClientRepository;
use App\Repository\RealisationRepository;
use App\Repository\TechnicienRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/realisation')]
class RealisationController extends AbstractController
{
    #[Route('/', name: 'app_realisation_index', methods: ['GET'])]
    public function index(RealisationRepository $realisationRepository): Response
    {
        $interventionAll = $realisationRepository->findRealisation();

        //dd($interventionAll);

        return $this->render('realisation/index.html.twig', [
            'realisations' => $interventionAll,  //On prend la requête et on la met dans intervention
        ]);
    }

    #[Route('/new', name: 'app_realisation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RealisationRepository $realisationRepository): Response
    {
        $realisation = new Realisation();
        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $realisationRepository->save($realisation, true);

            return $this->redirectToRoute('app_realisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('realisation/new.html.twig', [
            'realisation' => $realisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_realisation_show', methods: ['GET'])]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        //$client     = $clientRepository->findOneBy(['id'=>$realisation->getIdClient()]);
        //$technicien = $technicienRepository->findOneBy(['id'=> $realisation->getId()]);

        $realisation  = $entityManager->getRepository(realisation::class)->find($id);
        $client       = $realisation->getIdClient();
        $techniciens  = $realisation->getIdTechnicien();
        $categories   = $realisation->getCategorie();
        //dd($categories);

        return $this->render('realisation/show.html.twig', [
            'realisation' => $realisation,
            'client'      => $client,
            'categorie'   => $categories,
            'technicien'  => $techniciens,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_realisation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Realisation $realisation, RealisationRepository $realisationRepository): Response
    {
        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $realisationRepository->save($realisation, true);

            return $this->redirectToRoute('app_realisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('realisation/edit.html.twig', [
            'realisation' => $realisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_realisation_delete', methods: ['POST'])]
    public function delete(Request $request, Realisation $realisation, RealisationRepository $realisationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$realisation->getId(), $request->request->get('_token'))) {
            $realisationRepository->remove($realisation, true);
        }

        return $this->redirectToRoute('app_realisation_index', [], Response::HTTP_SEE_OTHER);
    }
}
