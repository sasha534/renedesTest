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

class AdminController extends Controller
{
    /**
     * @Route("/article-create", name="create_article")
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
//                $article->setTitle('Keyboard');
//                $article->setContent('SOme content 1111111111111111');
                $article->setUserId($this->getUser());

                $entityManager->persist($article);
                $entityManager->flush();

                $errors = $validator->validate($article);
                    if (count($errors) > 0) {
                        return new Response((string) $errors, 400);
                    }
            return $this->redirectToRoute('article_success');
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/cabinet/article/edit/{id}", name="article_edit")
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
