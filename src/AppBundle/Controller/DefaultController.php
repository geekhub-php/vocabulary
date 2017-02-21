<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Word\Word;
use AppBundle\Entity\Wishlist\Wishlist;
class DefaultController extends Controller
{
    /**
     * @Route("/{_locale}", requirements={"_locale" = "en|uk|bel"}, defaults={"_locale" = "en"}, name="homepage" )
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need

//        $t = $this->get('translator')->trans('tmp');

  //      return new Response($t);
        $em=$this->getDoctrine()->getManager();
        $userName = $em->getRepository('AppBundle:User\User')
            ->findByNameUser('user');
        $wishlist = $em->getRepository('AppBundle:Wishlist\Wishlist')
                 ->findAll();
        //$word->translate('en')->getName();

        dump($userName);
        //dump($request->getLocale());
        return $this->render('index.html.twig', array('wishlist'=>$wishlist));
    }

    /**
     * @Route("/{_locale}/information", requirements={"_locale" = "en|uk|bel"}, defaults={"_locale" = "en"}, name="information" )
     * @Method({"GET", "POST"})
     */
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

    /**
     * @Route("{_locale}/login", requirements={"_locale" = "en|uk|bel"}, defaults={"_locale" = "en"}, name="login" )
     * @Method({"GET", "POST"})
     */

    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        //dump($lastUsername);
        return $this->render('login.html.twig', array(
            'last_username' =>$lastUsername, //$lastUsername,
            'error'         => $error,
        ));
    }

}
