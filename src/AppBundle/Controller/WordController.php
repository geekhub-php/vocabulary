<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WordController extends Controller
{
    /**
     * @Route("/vocabulary", name="homepage")
     */
    public function indexAction()
    {
        $words = $this->getDoctrine()
            ->getRepository("AppBundle:Word")
            ->findAll();

        return $this->render(':word:index.html.twig', [
            'words' => $words,
            'users_words' => $this->getUser()->getWords()
        ]);
    }

    /**
     * @param Request $request
     * @Route("/vocabulary/words/new", name="new_word")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        /** @var \Symfony\Component\Form\Form $form */
        $form = $this->createFormBuilder()
            ->add('english', null, ['label_format' => 'site.new_word.english'])
            ->add('ukrainian', null, ['label_format' => 'site.new_word.ukrainian'])
            ->add('russian', null, ['label_format' => 'site.new_word.russian'])
            ->add('german', null, ['label_format' => 'site.new_word.german'])
            ->add('italian', null, ['label_format' => 'site.new_word.italian'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();

            $word = new Word();

            $data = $form->getData();

            $word->translate('en')->setName($data['english']);
            $word->translate('uk')->setName($data['ukrainian']);
            $word->translate('ru')->setName($data['russian']);
            $word->translate('de')->setName($data['german']);
            $word->translate('it')->setName($data['italian']);
            $em->persist($word);
            $word->mergeNewTranslations();
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render(':word:new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @param Word $word
     * @Route("/vocabulary/favorite/{id}", name="add_favorite")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addFavoriteAction(Word $word)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $this->getUser();

        $user->addWord($word);

        $word->addUser($user);

        $em->persist($user);

        $em->persist($word);

        $em->flush();

        return $this->redirectToRoute('homepage');
    }


    /**
     * @Route("/vocabulary/learning", name="learning")
     */
    public function showRandomFavoriteAction()
    {
        /** @var User $user */
        $user = $this->getUser();

        $words = $user->getWords();

        return $this->render(':word:learning.html.twig', [
            'words' => $words
        ]);
    }

}