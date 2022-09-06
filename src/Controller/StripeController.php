<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    #[Route('commande/create-session/{reference}', name: 'app_stripe_create_session')]
    public function index(Cart $cart, $reference, OrderRepository $orderRepository, ProductRepository $productRepository): Response
    {
        $order = $orderRepository->findOneBy(['reference' => $reference]);
        if (!$order) {
            new JsonResponse(['error' => 'order']);
        }

        $YOUR_DOMAIN = 'http://localhost:8000';
        foreach ($order->getOrderDetails()->getValues() as $product) {

            $product_object = $productRepository->findOneBy(['name' => $product->getProduct()]);
            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice() ,
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN . '/uploads/' . $product_object->getIllustration()],
                    ],
                ],
                'quantity' => $product->getQuantity(),
            ];
        }
        $product_for_stripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice() ,
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$YOUR_DOMAIN],
                ],
            ],
            'quantity' => 1,
        ];
        Stripe::setApiKey('sk_test_0LqdeJbNCEiQIWYn3Ccdfs7X00fvRWlYyy');
        $YOUR_DOMAIN = 'http://localhost:8000';
        $checkout_session = \Stripe\Checkout\Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [
                $product_for_stripe
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/error/{CHECKOUT_SESSION_ID}',
        ]);
        $order->setStripeSessionId($checkout_session->id);
        $orderRepository->add($order, true);
        $response = new JsonResponse(['id' => $checkout_session->id]);
        return $response;
    }
}
