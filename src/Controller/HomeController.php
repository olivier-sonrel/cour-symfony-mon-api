<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $articleRepo = $this->getDoctrine()->getRepository(Article::class);
        $datas = $articleRepo->findAll();
        $articles = array_reverse($datas);
        return $this->render("home/index.html.twig", [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/view/{id}", name="view")
     */
    public function view(Article $article): Response
    {
        if(!$article)
            return $this->redirectToRoute('home');

        return $this->render("home/view.html.twig", [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render("home/about.html.twig");
    }
}
