<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\OfferRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(OfferRepository $offersRepo, PaginatorInterface $paginator, Request $request): Response
    {
        // dump($offersRepo->findAll());

        $pagination = $paginator->paginate(
            $offersRepo->findByDate(),
            $request->query->getInt('page', 1), /*page number*/
            5,
        );
        return $this->render('main/index.html.twig', [
            "title" => "Dernières offres",
            "type" => "Offres récentes",
            "offers" => $pagination,
        ]);
    }
    /**
     * @Route("/home/{name}", name="app_home_category")
     */
    // J'affiche la même page mais avec un paramètre servant a trier les offres.
    public function index_category(Category $category, OfferRepository $offersRepo, PaginatorInterface $paginator, Request $request): Response
    {
        // dump($offersRepo->findByCategory($category));
        $pagination = $paginator->paginate(
            $offersRepo->findByCategory($category),
            $request->query->getInt('page', 1), /*page number*/
            5,
        );
        return $this->render('main/index.html.twig', [
            "title" => $category->getName(),
            "type" => $category->getName(),
            "offers" => $pagination,
        ]);
    }

}
