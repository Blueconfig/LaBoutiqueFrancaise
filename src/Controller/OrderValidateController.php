<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class OrderValidateController extends AbstractController
{
    #[Route('commande/merci/{stripeSessionId}', name: 'app_order_validate')]
    public function index(Cart $cart, $stripeSessionId, OrderRepository $orderRepository,  MailerInterface $mailer): Response
    {
        $order = $orderRepository->findOneBy([ 'stripeSessionId' => $stripeSessionId ]);
        if (!$order || $order->getRelation() != $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        if (!$order->isIsPaid()) {

            // Vider la session cart
            $cart->removeCart();
            // Modifier le statut isPaid de la commande en 1
            $order->setIsPaid(1);
            $order->setState(1);
            $orderRepository->add($order, true);
            // Envoyer un email de confirmation de commande
            $email = (new Email())
                ->from('no-reply@glessmer.fr')
                ->to($order->getRelation()->getEmail())
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Votre commande la boutique Française est bien validée')
                ->text('Sending emails is fun again!')
                ->html('<p>See Twig integration for better HTML integration!</p>');

            $mailer->send($email);

        }


        //Afficher les quelques infos de la commande
        return $this->render('order_validate/index.html.twig', [
            'order' => $order,
        ]);
    }

}
