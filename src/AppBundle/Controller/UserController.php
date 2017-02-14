<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\LoginForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

;

class UserController extends Controller
{

    /**
     * Show user list
     *
     * @Route("/user", name="user_index", requirements={"page": "\d+"})
     * @Method("GET")
     */
    public function indexAction(Request $request, $page = 1)
    {
        $user = $this->getUser();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $pagination = $this->get('knp_paginator')->paginate(
            $user->getWishList()->getWords(),
            $request->query->getInt('page', $page),
            5);

        return $this->render('AppBundle:user:show.html.twig', [
            'user' => $user,
            'words' => $pagination
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("/user/login", name="user_login")
     * @Method({"GET", "POST"})
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername,
        ]);
        return $this->render('AppBundle:user:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'form' => $form->createView(),
            'categories' => null,
        ));
    }

    /**
     * @Route("/user/logout", name="user_logout")
     */
    public function logoutAction()
    {
    }

    /**
     * Registering a new user
     *
     * @Route("/user/registration", name="user_registration")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->get('app.form.manager')->createRegisterUserForm($request, $user);

        if ($form instanceof Form) {
            return $this->render('AppBundle:user:new.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView(),
                )
            );
        } elseif ($form == true) {
            $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main');
            $request->getSession()->set('_locale', $user->getLanguage());
            return $this->redirectToRoute('homepage');
        }
    }


    /**
     * Editing user
     *
     * @Route("/user/edit", name="user_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $editForm = $this->get('app.form_manager')->createEditUserForm($request, $user);

        if ($editForm instanceof Form) {
            return $this->render('AppBundle:User:edit.html.twig', array(
                'user' => $user,
                'form' => $editForm->createView(),
                'categories' => null
            ));
        } else {
            return $this->redirect($editForm);
        }
    }
}
