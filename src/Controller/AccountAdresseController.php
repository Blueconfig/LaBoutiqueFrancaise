<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Adresses;
use App\Form\AdresseType;
use App\Repository\AdressesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdresseController extends AbstractController
{
    #[Route('/account/adresse', name: 'account_address')]
    public function index(): Response
    {
        return $this->render('account/adresse.html.twig', [
            'controller_name' => 'AccountAdresseController',
        ]);
    }
    #[Route('/account/ajouter-une-adresse', name: 'account_address_add')]
    public function add(Cart $cart, Request $request, AdressesRepository $adressesRepository): Response
    {
        $address = new Adresses();
        $form = $this->createForm(AdresseType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $adressesRepository->add($address, true);
            return $this->redirectToRoute('account_address');
        }


        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
