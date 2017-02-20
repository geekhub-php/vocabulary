<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Wishlist;
use AppBundle\Form\LoginType;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    /**
     * @Route("/signup", name="signup")
     * @Method({"GET", "POST"})
     *
     * @return Response
     */
    public function signupAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->setRoles(array('ROLE_USER'));

            $wishlist = new Wishlist();
            $wishlist->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($wishlist);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:user:signup.html.twig', array(
            'title' => $this->get('translator')->trans('user.signup'),
            'form'      => $form->createView()
        ));
    }

    /**
     * @Route("/users/{id}/{page}", requirements={"id": "\d+", "page": "\d+"}, name="user_show")
     * @Method("GET")
     *
     * @param User $user
     * @param int $page
     *
     * @return Response
     */
    public function showAction(User $user, $page = 1)
    {
        $words = $this->getDoctrine()
            ->getRepository('AppBundle:Word')
            ->findby(array(
                'user' => $user
            ));

        $pagination = $this->get('knp_paginator')->paginate(
            $words, $page, 5
        );

        return $this->render('AppBundle:user:show.html.twig', array(
            'title'      => $this->get('translator')->trans('word.titleMany'),
            'user'       => $user,
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param User $user
     *
     * @return Response
     */
    public function editAction(Request $request, User $user)
    {
        if ($this->getUser() != $user && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(UserType::class, $user, array(
            'authorizationChecker' => $this->get('security.authorization_checker')
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userData = $form->getData();

            if (!empty($user->getPlainPassword())) {
                $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($userData);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:user:edit.html.twig', array(
            'title' => $this->get('translator')->trans('user.profile.title'),
            'form'      => $form->createView()
        ));
    }

    /**
     * @Route("/users/{id}/delete", requirements={"id": "\d+"}, name="user_delete")
     * @Method({"GET", "POST"})
     *
     * @param User $user
     *
     * @return Response
     */
    public function deleteAction(User $user)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('word_index');
    }

    /**
     * @Route("/login", name="login")
     * @Method({"GET", "POST"})
     *
     * @return Response
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class, array(
            '_username' => $lastUsername
        ));

        return $this->render('AppBundle:user:login.html.twig', array(
            'title' => $this->get('translator')->trans('user.login'),
            'form'      => $form->createView(),
            'error'     => $error
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }
}
