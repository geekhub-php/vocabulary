<?php
/**
 * Created by PhpStorm.
 * User: xfly3r
 * Date: 01.02.17
 * Time: 16:21
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Word;
use AppBundle\Form\LoginForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;;

class WishlistController extends Controller
{
    /**
     * @param Request $request
     * @param Word $word
     * @Route("/wishlist/word/{id}/add", name="wishlist_word_add", requirements={"id": "\d"})
     */
    public function addWord(Request $request, Word $word)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        /**@var \AppBundle\Entity\Wishlist $wishlist*/
        $wishlist = $user->getWishlist();
        $wishlist->addWord($word);
        $em->persist($wishlist);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
    /**
     * @param Request $request
     * @param Word $word
     * @Route("/wishlist/word/{id}/delete", name="wishlist_word_delete", requirements={"id": "\d"})
     */
    public function deleteWord(Request $request, Word $word)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        /**@var \AppBundle\Entity\Wishlist $wishlist*/
        $wishlist = $user->getWishlist();
        $wishlist->removeWord($word);
        $em->persist($wishlist);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}