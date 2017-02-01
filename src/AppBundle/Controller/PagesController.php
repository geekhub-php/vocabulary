<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class PagesController extends Controller
{
    /**
     * Getting all existing posts.
     *
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $thisPage = $request->query->get('page');

        $words = $this->getDoctrine()->getRepository('AppBundle:Word')->getAllWords($thisPage);
        $pagesParameters = $this->get('app.pgManager')->paginate($thisPage, $words);

        return $this->render('AppBundle:Pages:homepage.html.twig', array('words' => $words, 'maxPages' => $pagesParameters[0], 'thisPage' => $pagesParameters[1]));
    }

    /**
     * Slider.
     *
     * @Route("/slider", name="slider")
     * @Template
     */
    public function sliderAction()
    {
        $result = $this->getUser()->getWishList()->getWords();
        $keys = $result->getKeys();
        shuffle($keys);
        if (count($result) < 5) {
            for ($i = 0; $i < count($result); ++$i) {
                $words[] = $result->get($keys[$i]);
            }
        } else {
            for ($i = 0; $i < 5; ++$i) {
                $words[] = $result->get($keys[$i]);
            }
        }

        $locales = array('en', 'fr', 'de', 'ru', 'uk');
        if (($key = array_search($this->getUser()->getLocale(), $locales)) !== false) {
            unset($locales[$key]);
        }

        return array('words' => $words, 'locales' => $locales);
    }

    /**
     * @Route("/login", name="login")
     * @Method({"GET", "POST"})
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('AppBundle:Pages:login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        return array('null' => null);
    }
}
