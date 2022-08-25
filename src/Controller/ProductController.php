<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/nos-produits', name: 'app_product')]
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $products = $productRepository->findWithSearch($search);
        } else {
            $products = $productRepository->findAll();
        }

        $products = $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/produits/{slug}', name: 'app_product_show')]
    public function show(ProductRepository $productRepository, Product $product): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'products' => $products
        ]);
    }
}
