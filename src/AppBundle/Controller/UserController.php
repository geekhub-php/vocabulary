<?php

namespace AppBundle\Controller;


use AppBundle\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @Route("/login", name="security_login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $form = $this->createForm(LoginType::class);

        return $this->render(':user:login.html.twig', [
           'form' => $form->createView()
        ]);
    }
}