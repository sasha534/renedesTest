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
     * @Route("/comment", name="comment")
     */
    public function index()
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * @Route("/add-comment", name="add_comment")
     */
    public function addComment(Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $form = $this->createFormBuilder($comment)
            ->add('title', TextType::class)
            ->add('content', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Save Comment'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

            $comment = $form->getData();
//            $comment->setTitle('Keyboard');
//            $comment->setContent('SOme content 1111111111111111');
            $comment->setUserId($this->getUser());
            $entityManager->persist($comment);
            $entityManager->flush();

            $errors = $validator->validate($comment);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }
            return $this->redirectToRoute('article_success');
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}