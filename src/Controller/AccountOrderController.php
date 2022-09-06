<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountOrderController extends AbstractController
{
    #[Route('/compte/mes-commandes', name: 'app_account_order')]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findBy(['relation' => $this->getUser()]);
        return $this->render('account_order/index.html.twig', [
            'orders' => $orders
        ]);
    }
    #[Route('/compte/mes-commandes/{reference}', name: 'app_account_order_show')]
    public function show($reference , OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findOneBy(['reference' => $reference]);
        if (!$order || $order->getRelation() != $this->getUser()) {
            return $this->redirectToRoute('app_account_order');
        }


        return $this->render('account_order/order_show.html.twig', [
            'order' => $order
        ]);
    }
}
