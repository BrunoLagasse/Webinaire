<?php

namespace App\Controller;

use App\Entity\Obj;
use App\Entity\Statistic;
use App\Entity\Demande;
use App\Form\DemandeType;
use Symfony\Component\Mime\Email;
use App\Repository\StatisticRepository;
use App\Repository\DemandeurRepository;
use Symfony\Component\Mailer\MailerInterface;
use App\Form\ObjType;
use App\Repository\ObjRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/obj')]
class ObjController extends AbstractController
{
    #[Route('/', name: 'obj_index', methods: ['GET'])]
    public function index(ObjRepository $objRepository): Response
    {
        return $this->render('obj/index.html.twig', [
            'objs' => $objRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'obj_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $obj = new Obj();
        $statistic = new Statistic();
        $form = $this->createForm(ObjType::class, $obj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($obj);
            $entityManager->persist($statistic);
            $entityManager->flush();

            return $this->redirectToRoute('obj_index');
        }

        return $this->render('obj/new.html.twig', [
            'obj' => $obj,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'obj_show', methods: ['GET', 'POST'])]
    public function show(Obj $obj,Request $request, MailerInterface $mailer, DemandeurRepository $demandeurRepository, StatisticRepository $statisticRepository, Statistic $statistic): Response
    {
        $demande = new Demande();

        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demandeur = $demandeurRepository->findOneBy(["email" => $demande->getPersonAsking()->getEmail()]);
            if($demandeur != null)
            {
                $demandeur->setCompany($demande->getPersonAsking()->getCompany());
                $demande->setPersonAsking($demandeur);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demande);
            $entityManager->flush();

            $email = (new Email())
                ->from('alain.renault.communication@example.com')
                ->to('brlagasse@example.com')
                ->subject('Une demande vient d\'être effectuée !')
                ->html('<p>Une demande vient d\'être effectuée !</p>');

            $mailer->send($email);

            $this->addFlash('success', 'Votre demande est bien enregistrée!');
            //  return $this->redirectToRoute('obj_show');
        }

        $entityManager = $this->getDoctrine()->getManager();

        $vue = $statistic->getVue();
        $vue = $vue + 1;
        $statistic->setVue($vue);
        $entityManager->flush();

        return $this->render('obj/show.html.twig', [
            'obj' => $obj,
            'form' => $form->createView(),
            'demande' => $demande,
            'statistic' => $statistic,
        ]);
    }

    #[Route('/{id}/edit', name: 'obj_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Obj $obj): Response
    {
        $form = $this->createForm(ObjType::class, $obj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('obj_index');
        }

        return $this->render('obj/edit.html.twig', [
            'obj' => $obj,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'obj_delete', methods: ['DELETE'])]
    public function delete(Request $request, Obj $obj): Response
    {
        if ($this->isCsrfTokenValid('delete'.$obj->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($obj);
            $entityManager->flush();
        }

        return $this->redirectToRoute('obj_index');
    }
}
