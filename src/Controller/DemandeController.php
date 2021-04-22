<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
use App\Entity\Demandeur;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\DemandeRepository;
use App\Repository\DemandeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\DemandeurController;

#[Route('/demande')]
class DemandeController extends AbstractController
{
    #[Route('/', name: 'demande_index', methods: ['GET'])]
    public function index(DemandeRepository $demandeRepository, DemandeurRepository $demandeurRepository): Response
    {
        return $this->render('demande/index.html.twig', [
            'demandes' => $demandeRepository->findAll(),
            'demandeurs' => $demandeurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'demande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MailerInterface $mailer, DemandeurRepository $demandeur): Response
    {
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($demande);
            // $existingUser = $em->getRepository(Demandeur::class)->findOneBy([
            //     'email' => $value['email'],
            // ]);
            // if($existingUser) {
            //     $demande->set;
            //     $entityManager->flush();
            // } else {
            //     // créer
            // }



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demande);
            $entityManager->flush();

            $email = (new Email())
                ->from('alain.renault.communication@example.com')
                ->to('brlagasse@example.com')
                ->subject('Une demande vient d\'être effectuée !')
                ->html('<p>Une demande vient d\'être effectuée !</p>');

            $mailer->send($email);
            
             return $this->redirectToRoute('demandeur_index');
        }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
        
        return $this->render('demande/new.html.twig', [
            'form' => $form->createView(),
            'demande' => $demande,
        ]);
    }

    #[Route('/{id}', name: 'demande_show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
        ]);
    }

    #[Route('/{id}/edit', name: 'demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demande $demande): Response
    {
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demande_index');
        }

        return $this->render('demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'demande_delete', methods: ['DELETE'])]
    public function delete(Request $request, Demande $demande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('demande_index');
    }
}

