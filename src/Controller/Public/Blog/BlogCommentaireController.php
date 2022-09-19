<?php

namespace App\Controller\Public\Blog;

use App\Entity\Blog\BlogCommentaire;
use App\Form\Blog\BlogCommentaireType;
use App\Repository\Blog\BlogCommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/public/blog/blog/commentaire')]
class BlogCommentaireController extends AbstractController
{
    #[Route('/', name: 'app_public_blog_blog_commentaire_index', methods: ['GET'])]
    public function index(BlogCommentaireRepository $blogCommentaireRepository): Response
    {
        return $this->render('public/blog/blog_commentaire/index.html.twig', [
            'blog_commentaires' => $blogCommentaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_public_blog_blog_commentaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BlogCommentaireRepository $blogCommentaireRepository): Response
    {
        $blogCommentaire = new BlogCommentaire();
        $form = $this->createForm(BlogCommentaireType::class, $blogCommentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogCommentaireRepository->add($blogCommentaire, true);

            return $this->redirectToRoute('app_public_blog_blog_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('public/blog/blog_commentaire/new.html.twig', [
            'blog_commentaire' => $blogCommentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_public_blog_blog_commentaire_show', methods: ['GET'])]
    public function show(BlogCommentaire $blogCommentaire): Response
    {
        return $this->render('public/blog/blog_commentaire/show.html.twig', [
            'blog_commentaire' => $blogCommentaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_public_blog_blog_commentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BlogCommentaire $blogCommentaire, BlogCommentaireRepository $blogCommentaireRepository): Response
    {
        $this->denyAccessUnlessGranted('POST_EDIT', $blogCommentaire);
        $form = $this->createForm(BlogCommentaireType::class, $blogCommentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogCommentaireRepository->add($blogCommentaire, true);

            return $this->redirectToRoute('app_public_blog_blog_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('public/blog/blog_commentaire/edit.html.twig', [
            'blog_commentaire' => $blogCommentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_public_blog_blog_commentaire_delete', methods: ['POST'])]
    public function delete(Request $request, BlogCommentaire $blogCommentaire, BlogCommentaireRepository $blogCommentaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blogCommentaire->getId(), $request->request->get('_token'))) {
            $blogCommentaireRepository->remove($blogCommentaire, true);
        }

        return $this->redirectToRoute('app_public_blog_blog_commentaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
