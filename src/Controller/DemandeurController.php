<?php

namespace App\Controller;

use App\Entity\Demandeur;
use App\Entity\Obj;
use App\Form\DemandeurType;
use App\Repository\DemandeRepository;
use App\Repository\DemandeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ObjRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/demandeur')]
class DemandeurController extends AbstractController
{
    #[Route('/', name: 'demandeur_index', methods: ['GET', 'POST'])]
    public function index(DemandeurRepository $demandeurRepository, ObjRepository $objRepository, DemandeRepository $demandeRepository, $email): Response
    {
        // $demandeurRepository = $this->getDoctrine()->getRepository(Demandeur::class);
        // $demandeur = $demandeurRepository->find($id);
        // dd($demandeur);


        // $existingEmail = $this->getDoctrine()
        //     ->getRepository(Demandeur::class)
        //     ->nom($email);

        // dd($existingEmail);
            $email = $demandeurRepository->getId($email);

            return $this->render('demandeur/index.html.twig', [
                'demandeurs' => $email,
                'obj_requested' => $objRepository->findAll(),
                'demande'=> $demandeRepository->findAll(),

            ]);
    }

    #[Route('/new', name: 'demandeur_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $demandeur = new Demandeur();
        $form = $this->createForm(DemandeurType::class, $demandeur);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demandeur);
            $entityManager->flush();

            $id = $demandeur->getId();
            $emailPost = isset($_POST['email']);
            $emailAlreaydInDb = $demandeur->getEmail();

            if($emailPost == $emailAlreaydInDb)
            {
                return "voici l\'".$id;
            } 

            return $this->redirectToRoute('demandeur_index');
        }

        return $this->render('demandeur/new.html.twig', [
            'demandeur' => $demandeur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'demandeur_show', methods: ['GET'])]
    public function show(Demandeur $demandeur): Response
    {
        return $this->render('demandeur/show.html.twig', [
            'demandeur' => $demandeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'demandeur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demandeur $demandeur): Response
    {
        $form = $this->createForm(DemandeurType::class, $demandeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demandeur_index');
        }

        return $this->render('demandeur/edit.html.twig', [
            'demandeur' => $demandeur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'demandeur_delete', methods: ['DELETE'])]
    public function delete(Request $request, Demandeur $demandeur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandeur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demandeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('demandeur_index');
    }

    public function list (EntityManagerInterface $em) {
        $repository = $em->getRepository(Demandeur::class);
        
        $demandeurs= $repository->findDemandeurId(); // On l'utilise de la même manière que les autres fonctions !
    
        if(!$demandeurs) {
            throw $this->createNotFoundException('Sorry, no monkey came for the banana this time');
        }
    
        return $this->render('demandeur/index.html.twig', [
            "demandeurs" => $demandeurs
        ]);
    }
}
