<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Wishlist;
use AppBundle\Form\LoginType;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
