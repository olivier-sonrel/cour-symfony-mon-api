<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $repoArticle;
    private $repoCategory;

    public function __construct(ArticleRepository $articleRepository, CategoryRepository $categoryRepository)
    {
        $this->repoArticle = $articleRepository;
        $this->repoCategory = $categoryRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        return $this->render("home/index.html.twig", [
            'articles' => array_reverse($this->repoArticle->findAll()),
            'categories' => $this->repoCategory->findAll(),
        ]);
    }

    /**
     * @Route("/show_by_category/{id}", name="show_by_category")
     */
    public function showByCategory(Category $category): Response
    {
        return $this->render("home/index.html.twig", [
            'articles' => $category->getArticles(),
            'categories' => $this->repoCategory->findAll(),
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
