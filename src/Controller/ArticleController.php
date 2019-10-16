<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller;
use App\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="articles_list")
     */
    public function articlesList(Request $request, PaginatorInterface $paginator)
    {
        $article = $this->getDoctrine()->getRepository(Article::class);
        $query = $article->findAll();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('article/list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function articleShow(Request $request, $id, PaginatorInterface $paginator, ValidatorInterface $validator)
    {
        $articles = $this->getDoctrine()->getRepository(Article::class);
        $article = $articles->find($id);

        $comment = new Comment();
        $form = $this->createFormBuilder($comment)
            ->add('authorName', TextType::class)
            ->add('content', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Save Comment'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $comment->setArticle($article);

            $comment = $form->getData();

            $entityManager->persist($comment);
            $entityManager->flush();

            $errors = $validator->validate($comment);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }
            return $this->redirectToRoute('article_show', array('id' => $id));
        }

        $comments = $this->getDoctrine()->getRepository(Comment::class);
        $query = $comments->findAll();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('article/index.html.twig', ['article' => $article, 'pagination' => $pagination, 'form' => $form->createView()]);
    }

}
