<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Word;
use AppBundle\Repository\WordRepository;
use AppBundle\Form\WordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class WordController.
 */
class WordController extends Controller
{
    /**
     * @Route("/{page}", requirements={"page": "\d+"}, name="homepage")
     * @Route("/{page}", requirements={"page": "\d+"}, name="word_index")
     * @Method("GET")
     *
     * @param int $page
     *
     * @return Response
     */
    public function indexAction($page = 1)
    {
        $words = $this->getDoctrine()
            ->getRepository('AppBundle:Word')
            ->findAllWords();

        $pagination = $this->get('knp_paginator')->paginate(
            $words, $page, 5
        );

        return $this->render('AppBundle:word:index.html.twig', array(
            'title'      => $this->get('translator')->trans('word.titleMany'),
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/words/new", name="word_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('create_word', $this->getUser());

        $word = new Word();
        $word->setUser($this->getUser());

        $form = $this->createForm(WordType::class, $word, [
            'authorizationChecker' => $this->get('security.authorization_checker')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wordData = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($wordData);
            $em->flush();

            return $this->redirectToRoute('word_index');
        }

        return $this->render('AppBundle:word:new.html.twig', array(
            'title' => $this->get('translator')->trans('word.new'),
            'form'      => $form->createView()
        ));
    }

    /**
     * @Route("/words/{id}/edit", requirements={"id": "\d+"}, name="word_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Word    $word
     *
     * @return Response
     */
    public function editAction(Request $request, Word $word)
    {
        $this->denyAccessUnlessGranted('edit_word', $this->getUser());

        $form = $this->createForm(WordType::class, $word, [
            'authorizationChecker' => $this->get('security.authorization_checker')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wordData = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($wordData);
            $em->flush();

            return $this->redirectToRoute('word_index');
        }

        return $this->render('AppBundle:word:edit.html.twig', array(
            'title' => $this->get('translator')->trans('word.edit'),
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/words/{id}/delete", requirements={"id": "\d+"}, name="word_delete")
     * @Method({"GET", "POST"})
     *
     * @param Word $word
     *
     * @return Response
     */
    public function deleteAction(Word $word)
    {
        $this->denyAccessUnlessGranted('edit', $word);

        $em = $this->getDoctrine()->getManager();

        $em->remove($word);
        $em->flush();

        return $this->redirectToRoute('word_index');
    }
}
