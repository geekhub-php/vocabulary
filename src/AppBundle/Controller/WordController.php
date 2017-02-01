<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Word;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class WordController extends Controller
{
    /**
     * Word create.
     *
     * @Route("/word/create", name="word_new")
     */
    public function wordAction(Request $request)
    {
        $form = $this->createFormBuilder(null)
            ->add('english', TextType::class)
            ->add('french', TextType::class)
            ->add('german', TextType::class)
            ->add('russian', TextType::class)
            ->add('ukrainian', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->get('app.dbManager')->saveWord($data);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Pages:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Word update.
     *
     * @Route("/word/update/{id}", name="word_update")
     * @ParamConverter("word", class="AppBundle:Word")
     */
    public function wordUpdateAction(Request $request, Word $word)
    {
        $form = $this->createFormBuilder(null)
            ->add('english', TextType::class, [
                'data' => $word->translate('en')->getName(),

            ])
            ->add('french', TextType::class, [
                'data' => $word->translate('fr')->getName(),

            ])
            ->add('german', TextType::class, [
                'data' => $word->translate('de')->getName(),

            ])
            ->add('russian', TextType::class, [
                'data' => $word->translate('ru')->getName(),

            ])
            ->add('ukrainian', TextType::class, [
                'data' => $word->translate('uk')->getName(),

            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->get('app.dbManager')->saveWord($data, $word);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Pages:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
