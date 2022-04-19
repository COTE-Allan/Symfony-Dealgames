<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user/profile", name="app_profile")
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response
    {
        if (!$this->isGranted("ROLE_USER")){
            // Do Things
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('user/index.html.twig', [
            "user" => $this->getUser(),
        ]);
    }
     /**
     * @Route("/user/profile/edit", name="app_profile_edit")
     * @IsGranted("ROLE_USER")
     */
    public function edit_profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer user
        $user = $this->getUser();
        $form = $this->createForm(RegistrationFormType::class, $user, [
            "edit" => true,
        ]);
        $form->handleRequest($request);

        // Si form submit
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();        
            return $this->redirectToRoute('app_profile');
        }
        // Template edit
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
