<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderCancelController extends AbstractController
{
    #[Route('/commande/erreur/{stripeSessionId}', name: 'app_order_validate')]
    public function cancel($stripeSessionId, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findOneBy([ 'stripeSessionId' => $stripeSessionId ]);
        if (!$order || $order->getRelation() != $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // Envoyer un email de confirmation de commande

        //Afficher les quelques infos de la commande
        return $this->render('order_validate/cancel.html.twig', [
            'order' => $order,
        ]);
    }
}
