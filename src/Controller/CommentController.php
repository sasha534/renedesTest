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
use App\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class CommentController extends AbstractController
{
    /**
     * @Route("/article-comments", name="article_comments")
     */
    public function articleComments(Request $request, PaginatorInterface $paginator)
    {
        $comments = $this->getDoctrine()->getRepository(Comment::class);
        $query = $comments->findAll();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('comments/list.html.twig', ['pagination' => $pagination]);

    }
}
