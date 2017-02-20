<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Wishlist;
use AppBundle\Entity\Word;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class WishlistController.
 */
class WishlistController extends Controller
{
    /**
     * @Route("/wishlist/{id}/{page}",
     *     requirements={"id": "\d+", "page": "\d+"},
     *     name="wishlist_show"
     * )
     * @Method("GET")
     *
     * @param Wishlist $wishlist
     * @param int $page
     *
     * @return Response
     */
    public function showAction(Wishlist $wishlist, $page = 1)
    {
        $this->denyAccessUnlessGranted('edit', $wishlist);

        $words = $this->getDoctrine()
            ->getRepository('AppBundle:Word')
            ->findAllByWishlist($wishlist->getId());

        $pagination = $this->get('knp_paginator')->paginate(
            $words, $page, 5
        );

        return $this->render('AppBundle:word:index.html.twig', array(
            'title'      => $this->get('translator')->trans('wishlist.title'),
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/wishlist/{id}/add/{wordId}",
     *     requirements={"id": "\d+", "wordId": "\d+"},
     *     name="wishlist_add_word"
     * )
     * @ParamConverter("word", options={"mapping": {"wordId": "id"}})
     * @Method({"GET"})
     *
     * @param Wishlist $wishlist
     * @param Word $word
     *
     * @return Response
     */
    public function addWordAction(Wishlist $wishlist, Word $word)
    {
        $this->denyAccessUnlessGranted('edit', $wishlist);

        $wishlist->addWord($word);

        $em = $this->getDoctrine()->getManager();
        $em->persist($wishlist);
        $em->flush();

        return $this->redirectToRoute('wishlist_show', ['id' => $wishlist->getId()]);
    }

    /**
     * @Route("/wishlist/{id}/delete/{wordId}",
     *     requirements={"id": "\d+", "wordId": "\d+"},
     *     name="wishlist_remove_word"
     * )
     * @ParamConverter("word", options={"mapping": {"wordId": "id"}})
     * @Method({"GET"})
     *
     * @param Wishlist $wishlist
     * @param Word $word
     *
     * @return Response
     */
    public function removeWordAction(Wishlist $wishlist, Word $word)
    {
        $this->denyAccessUnlessGranted('edit', $wishlist);

        $wishlist->removeWord($word);
        $word->removeWishlist($wishlist);

        $em = $this->getDoctrine()->getManager();

        $em->persist($wishlist);
        $em->persist($word);
        $em->flush();

        return $this->redirectToRoute('wishlist_show', ['id' => $wishlist->getId()]);
    }
}
