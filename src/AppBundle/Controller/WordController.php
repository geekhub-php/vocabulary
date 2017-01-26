<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Word;
use AppBundle\Form\TranslateType;
use AppBundle\Form\WordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WordController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $words = $this->getDoctrine()
            ->getRepository("AppBundle:Word")
            ->findAll();

        return $this->render(':word:index.html.twig', [
            'words' => $words
        ]);
    }

    /**
     * @param Request $request
     * @Route("/words/new", name="new_word")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(WordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();

            $entity = $form->getData();

            $em->persist($entity);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render(':word:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

}