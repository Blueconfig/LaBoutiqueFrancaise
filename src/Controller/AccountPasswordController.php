<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    #[Route('/account/password', name: 'app_account_password')]
    public function index(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $encoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($encoder->isPasswordValid($user, $form->get('old_Password')->getData())) {
                $user->setPassword(
                    $encoder->hashPassword(
                        $user,
                        $form->get('new_password')->getData()
                    )
                );
                $userRepository->add($user, true);
                $this->addFlash('success', 'Votre mot de passe a bien été modifié');
                return $this->redirectToRoute('app_account');
            } else {
                $this->addFlash('danger', 'Votre mot de passe actuel est incorrect');
            }

            $this->addFlash('success', 'Votre mot de passe a bien été modifié');
            return $this->redirectToRoute('app_account');
        }
        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
