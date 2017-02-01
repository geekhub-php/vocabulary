<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WishList;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\WishListType;

class WishListController extends Controller
{
    /**
     * Wish list create.
     *
     * @Route("/wish_list/create", name="wish_list")
     */
    public function wishListAction(Request $request)
    {
        $wish_list = new WishList();
        $user = $this->getUser();
        $wish_list->setUser($user);
        $form = $this->createForm(WishListType::class, $wish_list);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($wish_list);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Pages:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Wish list update.
     *
     * @Route("/wish_list/update", name="wish_list_update")
     */
    public function wishListUpdateAction(Request $request)
    {
        $user = $this->getUser();
        $wish_list = $user->getWishList();
        $form = $this->createForm(WishListType::class, $wish_list);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($wish_list);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Pages:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
