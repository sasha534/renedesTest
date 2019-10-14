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

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $article = $this->getDoctrine()->getRepository(Article::class);
        $query = $article->findAll();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        // parameters to template
        return $this->render('article/list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/article-create", name="create_article")
     */
    public function createArticle(Request $request, ValidatorInterface $validator): Response
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $userID = $user->getId();

        $entityManager = $this->getDoctrine()->getManager();

        $article = new Article();
        $article->setTitle('Keyboard');
        $article->setContent('SOme content 1111111111111111');
        $article->setUserId($userID);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($article);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $errors = $validator->validate($article);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
    }

    /**
     * @Route("/article/edit/{id}", name="article_edit")
     */
    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id '.$id
            );
        }

        $article->setName('New article name!');
        $entityManager->flush();

        return $this->redirectToRoute('article_show', [
            'id' => $article->getId()
        ]);
    }

}
