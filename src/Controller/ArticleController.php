<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles-list", name="articles_list")
     */
    public function articlesList(Request $request, PaginatorInterface $paginator)
    {
        $article = $this->getDoctrine()->getRepository(Article::class);
        $query = $article->findAll();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('article/list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/article/{id}", name="article_id")
     */
    public function articleShow(Request $request, $id)
    {
        $articles = $this->getDoctrine()->getRepository(Article::class);
        $article = $articles->find($id);

        return $this->render('article/index.html.twig', ['article' => $article]);
    }


}
