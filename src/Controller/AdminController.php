<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Comment;
use App\Form\Type\ArticleFormType;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/article-create", name="create_article")
     */
    public function createArticle(Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = new Article();
        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class)
            ->add('content', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Article'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
                $article = $form->getData();
                $article->setUserId($this->getUser());

                $entityManager->persist($article);
                $entityManager->flush();

                $errors = $validator->validate($article);
                    if (count($errors) > 0) {
                        return new Response((string) $errors, 400);
                    }
                $this->addFlash('success', 'Article Created! Success!');

                return $this->redirectToRoute('create_article');
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article/{id}/edit", name="article_edit")
     */
    public function updateArticle(Article $article, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();
            $em->persist($article);
            $em->flush();
            return $this->render('admin/edit.html.twig', [
                'articleForm' => $form->createView()
            ]);
        }

        return $this->render('admin/edit.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/articles", name="articles_admin")
     */

    public function listArticles(Request $request, PaginatorInterface $paginator)
    {
        $id = $this->getUser() -> getId();
        $articles = $this->getDoctrine()->getRepository(Article::class)->findBy(['user' => $id]);

        $pagination = $paginator->paginate(
            $articles,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('admin/articles-list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/admin/article/{id}/delete", name="articles_delete")
     */

    public function deleteArticle(Article $article)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($article);

        if (!$article) {
            throw $this->createNotFoundException(sprintf(
                'No programmer found with nickname "%s"',
                $article
            ));
        }

        if ($article) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        $comment = $this->getDoctrine()->getRepository(Comment::class)->findBy(['article_id' => $article->getId()]);

        if ($comment === null) {
            $comments = $this->getDoctrine()->getManager();
            $comments->remove($comment);
            $comments->flush();
        }

        //$this->addFlash('deleteArticle', 'L\'article was deleted');

        return $this->redirectToRoute('articles_admin');
    }

}
