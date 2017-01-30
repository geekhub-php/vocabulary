<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Word\Word;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need

//        $t = $this->get('translator')->trans('tmp');

  //      return new Response($t);
        $em=$this->getDoctrine()->getManager();
        $word = $em->getRepository('AppBundle:Word\Word')->findOneById(5);
        //$word->translate('en')->getName();
         dump($word->translate('EN')->getName());
        return $this->render('index.html.twig', array('data' => $word->translate('EN')->getName()));
    }


    public function informationAction(Request $request)
    {

/*
        $word = new Word;
        $word->translate('fr')->setName('Chaussures');
        $word->translate('en')->setName('Shoes');
        $em=$this->getDoctrine()->getManager();
        $em->persist($word);
        $word->mergeNewTranslations();
        $em->flush();

*/
        //$category->translate('en')->getName();

        return $this->render('index.html.twig', array('data' => "data"));
    }
}
