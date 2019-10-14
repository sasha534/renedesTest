<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;


class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {


        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/show", name="show_article")
     */
    public function show()
    {
        $article = $this->getDoctrine()->getRepository(Article::class);
        $posts = $article->findAll();
//        var_dump($posts);die();





        return $this->render('article/index.html.twig', $posts);
    }

}
