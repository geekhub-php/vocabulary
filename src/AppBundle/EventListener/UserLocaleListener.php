<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Stores the locale of the user in the session after the
 * login. This can be used by the LocaleListener afterwards.
 */
class UserLocaleListener
{
    /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        /**@var \AppBundle\Entity\User $user */
        $user = $event->getAuthenticationToken()->getUser();
        /**@var \AppBundle\Entity\Language $language */
        $language = $user->getLanguage();
        $locale = $language->getValue();
        if (null !== $locale) {
            $this->session->set('_locale', $locale);
        }
    }
}
