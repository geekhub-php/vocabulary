<?php

namespace AppBundle\Security;

use AppBundle\Entity\Wishlist;
use AppBundle\Entity\Word;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AppVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW        = 'view';
    const EDIT        = 'edit';
    const CREATE_WORD = 'create_word';
    const EDIT_WORD   = 'edit_word';

    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    /**
     * AppVoter constructor.
     * @param AccessDecisionManagerInterface $decisionManager
     */
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    /**
     * @inheritdoc
     */
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(
            self::VIEW, self::EDIT, self::CREATE_WORD, self::EDIT_WORD
        ))) {
            return false;
        }

        // only vote on this objects inside this voter
        if (!(
            $subject instanceof Word ||
            $subject instanceof User ||
            $subject instanceof Wishlist
        )) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        $roleAdmin = $this->decisionManager->decide($token, array('ROLE_ADMIN'));
        $roleUser = $this->decisionManager->decide($token, array('ROLE_USER'));

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_ADMIN can do anything! The power!
        if ($roleAdmin) {
            return true;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($subject, $user);
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::CREATE_WORD:
                if ($roleUser) {
                    return true;
                }
            case self::EDIT_WORD:
                if ($roleUser) {
                    return true;
                }
        }

        return false;
    }

    /**
     * @param mixed $subject
     * @param User  $user
     *
     * @return bool
     */
    private function canView($subject, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($subject, $user)) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $subject
     * @param User  $user
     *
     * @return bool
     */
    private function canEdit($subject, User $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $subject->getUser();
    }
}
