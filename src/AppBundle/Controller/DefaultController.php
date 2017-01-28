<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need

//        $t = $this->get('translator')->trans('tmp');

  //      return new Response($t);


         return $this->render('index.html.twig', array('data' => "data"));
    }


    public function informationAction(Request $request)
    {

        return $this->render('index.html.twig', array('data' => "data"));
    }
}
