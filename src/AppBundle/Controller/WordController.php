<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Wishlist;
use AppBundle\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Word controller.
 *
 */
class WordController extends Controller
{
    /**
     * Lists all word entities.
     *
     * @Route("/{page}", name="homepage", requirements={"page": "\d+"})
     * @Method("GET")
     */
    public function indexAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($user instanceof User) {
            $wishlist = $user->getWishlist();
        } else {
            $wishlist = null;
        }
        $words = $em->getRepository('AppBundle:Word')->findAll();

        $pagination = $this->get('knp_paginator')->paginate($words,
            $request->query->getInt('page', $page),
            30);
        /**@var Wishlist $wishlist*/
        return $this->render('AppBundle:word:index.html.twig', array(
            'words' => $pagination,
            'wishlist' => $wishlist,
        ));
    }

    /**
     * Creates a new word entity.
     *
     * @Route("/word/new", name="word_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->get('app.form.manager')->createWordForm($request);
        if ($form instanceof Form) {
            return $this->render('AppBundle:word:new.html.twig', array(
                'form' => $form->createView(),
            ));
        } else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * Finds and displays a word entity.
     *
     * @Route("/word/{id}", name="word_show")
     * @Method("GET")
     */
    public function showAction(Word $word)
    {
        $deleteForm = $this->createDeleteForm($word);

        return $this->render('word/show.html.twig', array(
            'word' => $word,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
