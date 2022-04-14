<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/offer")
 */
class OfferController extends AbstractController
{

    /**
     * @Route("/remove/{id}", name="app_offer_remove")
     */
    public function remove_offer(OfferRepository $offerRepo, Offer $offer): Response
    {
        $offer->setPictureName("");
        $offerRepo->remove($offer);
        $this->addFlash('success', 'Votre offre a été retiré avec succès.');
        return $this->redirectToRoute("app_home");
    }
    /**
     * @Route("/add", name="app_offer_add")
     */
    public function add_offer(Request $request, OfferRepository $offerRepo): Response
    {
        if (!$this->isGranted("ROLE_USER")){
            // Do Things
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }
        $offer = new Offer;
        $user = $this->getUser();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $offer->setPublished(new DateTime());
            $offer->setUser($user);
            $offerRepo->add($offer);
            $this->addFlash('success', 'Votre offre a été créée avec succès.');
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('offer/add.html.twig', [
            "form" => $form,
        ]);
    }
    /**
     * @Route("/{id}", name="app_offer")
     */
    public function index(Offer $offer): Response
    {
        return $this->render('offer/index.html.twig', [
            "offer" => $offer,
        ]);
    }
    /**
     * @Route("/edit/{id}", name="app_offer_edit")
     */
    public function edit_offer(Offer $offer, Request $request, OfferRepository $offerRepo): Response
    {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $offerRepo->add($offer);
            $this->addFlash('success', 'Votre offre a été modifié avec succès.');
            return $this->redirectToRoute("app_offer", ["id" => $offer->getId()]);
        };
        return $this->renderForm('offer/edit.html.twig', [
            "form" => $form,
        ]);
    }
}
