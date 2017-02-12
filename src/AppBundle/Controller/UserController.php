<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\RegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Method({"GET", "POST"})
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(':user:login.html.twig', array(
            'last_username' => $lastUsername, //$lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/locale", name="locale")
     */
    public function localeAction(Request $request)
    {
        if ($request->getSession()->get('_locale') == 'en') {
            $request->getSession()->set('_locale', 'uk');
        } else {
            $request->getSession()->set('_locale', 'en');
        }

        return $this->redirect($request->headers->get('referer'), 302);
    }

    /**
     * @param Request $request
     * @Route("/registration", name="registration")
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($user);

            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render(':user:registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
