<?php
/**
 * Created by PhpStorm.
 * User: nima
 * Date: 04.02.17
 * Time: 11:43
 */

namespace AppBundle\Controller\Wishlist;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Word\Word;
use AppBundle\Entity\Wishlist\Wishlist;
use AppBundle\Form\WishlistType;

class WishlistController extends Controller
{
    /**
     * @Route("{_locale}/admin/{id}", requirements={"id" = "\d+",  "_locale" = "en|uk|bel"}, defaults={"id" =1, "_locale" = "en"}, name="admin" )
     * @Method({"GET", "POST"})
     */

    public function editWishlistAction(Request $request, Wishlist $wishlist, $id)
    {
       /* $wishlist = $this->getDoctrine()
            ->getRepository('AppBundle:Wishlist\Wishlist')
            ->find($id);
       */
        $editForm = $this->createForm(WishlistType::class, $wishlist,
            array('locale' =>$request->getLocale())
           // ['em' => $this->getDoctrine()->getManager(),]
            );

        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            //$post->setDataEdit(new \DateTime("now"));
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('admin');
        }
          dump($wishlist->getWords());
          return $this->render('admin/index.html.twig', array(
            'wishlist' => $wishlist,
            // 'id' =>$id,
            'edit_form' => $editForm->createView(),
              'words'=>$wishlist->getWords(),

        ));
    }
}