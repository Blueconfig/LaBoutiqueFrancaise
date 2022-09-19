<?php

namespace App\Security\Voter;

use App\Entity\Blog\BlogCommentaire;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentairesVoter extends Voter
{
    public const EDIT = 'COMMENTAIRE_EDIT';
    public const DELETE = 'COMMENTAIRE_DELETE';
    public const VIEW = 'COMMENTAIRE_VIEW';

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [ self::EDIT, self::DELETE , self::VIEW ])
            && $subject instanceof \App\Entity\Blog\BlogCommentaire;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        // On verifie si le commentaire à un auteur
        if (null === $subject->getPoster()) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // On verifie si on peut éditer le commentaire
                return $this->canEdit($subject, $user);
                break;
            case self::DELETE:
                // On verifie si on peut supprimer le commentaire
                return $this->canDelete($subject, $user);
                break;
            case self::VIEW:
                // On verifie si l'utilisateur peut voir le commentaire
                return $this->canView($subject, $user);
                break;
        }

        return false;
    }

    private function canView(BlogCommentaire $commentaire, User $user): bool
    {
        // le poster du commentaire peu modifier
        return $user === $commentaire->getPoster();
    }

    private function canEdit(BlogCommentaire $commentaire, User $user): bool
    {
        // le poster du commentaire peu modifier
        if($commentaire->isEtat() != null){
            return false;
        }
        return $user === $commentaire->getPoster();
    }

    private function canDelete(BlogCommentaire $commentaire, User $user): bool
    {
        // Le poster peut supprimer son commentaire
        return $user === $commentaire->getPoster();
    }
}
