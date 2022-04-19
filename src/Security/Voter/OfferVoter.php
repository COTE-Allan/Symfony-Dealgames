<?php

namespace App\Security\Voter;

use App\Entity\Offer;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class OfferVoter extends Voter
{
    public const EDIT = 'OFFER_EDIT';

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT])
            && $subject instanceof \App\Entity\Offer;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        if ($this->security->isGranted("ROLE_ADMIN")){
            return true;
        }
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $user === $subject->getUser();
                break;
        }

        return false;
    }
}
