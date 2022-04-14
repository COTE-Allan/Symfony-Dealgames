<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user/profile", name="app_profile")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            "user" => $this->getUser(),
        ]);
    }
}
