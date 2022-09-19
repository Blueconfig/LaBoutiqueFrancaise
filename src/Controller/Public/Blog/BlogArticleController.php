<?php

namespace App\Controller\Public\Blog;

use App\Entity\Blog\BlogArticle;
use App\Entity\Blog\BlogCommentaire;
use App\Form\Blog\BlogArticleType;
use App\Form\Blog\BlogCommentaireType;
use App\Repository\Blog\BlogArticleRepository;
use App\Repository\Blog\BlogCommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog')]
class BlogArticleController extends AbstractController
{
    #[Route('/', name: 'app_public_blog_blog_article_index', methods: ['GET'])]
    public function index(BlogArticleRepository $blogArticleRepository): Response
    {
        return $this->render('public/blog/blog_article/index.html.twig', [
            'blog_articles' => $blogArticleRepository->findAll(),
        ]);
    }



    #[Route('/{slug}', name: 'app_public_blog_blog_article_show', methods: ['GET', 'POST'])]
    public function show(BlogArticle $blogArticle, BlogArticleRepository $blogArticleRepository, Request $request, BlogCommentaireRepository $blogCommentaireRepository): Response
    {
        $blogCommentaire = new BlogCommentaire();
        if($this->getUser()){
            $blogCommentaire->setName($this->getUser()->getFirstname().' '.$this->getUser()->getLastname());
            $blogCommentaire->setEmail($this->getUser()->getEmail());
            $blogCommentaire->setPoster($this->getUser());
        }
        $blogCommentaire->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(BlogCommentaireType::class, $blogCommentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogCommentaire->setArticle($blogArticle);

            $blogCommentaireRepository->add($blogCommentaire, true);

            return $this->redirectToRoute('app_public_blog_blog_article_show', ['slug'=> $blogCommentaire->getArticle()->getSlug(), '_fragment' => 'comments'], Response::HTTP_SEE_OTHER);
        }

        $last_articles = $blogArticleRepository->findBy([], ['createdAt' => 'DESC'], 3);
        return $this->render('public/blog/blog_article/show.html.twig', [
            'blog_article' => $blogArticle,
            'last_articles' => $last_articles,
            'form' => $form->createView(),
            'commentaires' => $blogCommentaireRepository->findBy(['article' => $blogArticle], ['createdAt' => 'ASC']),
        ]);
    }

}
