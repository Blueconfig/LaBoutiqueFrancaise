<?php

namespace App\Classe;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private RequestStack $requestStack;
    private ProductRepository $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;
    }
    public function add($id): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);

    }
    public function getCart(): array
    {
        $session = $this->requestStack->getSession();
        return $session->get('cart', []);
    }
    public function removeCart()
    {
        $session = $this->requestStack->getSession();
        return $session->remove('product');
    }
    public function delete($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        unset($cart[$id]);

        return $session->set('cart', $cart);
    }
    public function decrease($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        return $session->set('cart', $cart);
    }

    public function getFull()
    {
        $cartComplete = [];

        if ($this->getCart()) {
            foreach ($this->getCart() as $id => $quantity) {
                $product_object = $this->productRepository->findOneById($id);

                if (!$product_object) {
                    $this->delete($id);
                    continue;
                }

                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }

        return $cartComplete;
    }

}
