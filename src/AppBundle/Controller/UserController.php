<?php

namespace AppBundle\Controller;


use AppBundle\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Method({"GET", "POST"})
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(':user:login.html.twig', array(
            'last_username' =>$lastUsername, //$lastUsername,
            'error'         => $error,
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
        }else{
            $request->getSession()->set('_locale', 'en');
        }

        return $this->redirectToRoute('homepage');
    }

}