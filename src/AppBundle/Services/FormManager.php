<?php
/**
 * Created by PhpStorm.
 * User: xfly3r
 * Date: 31.01.17
 * Time: 17:30
 */

namespace AppBundle\Services;


use AppBundle\Entity\User;
use AppBundle\Entity\Wishlist;
use AppBundle\Form\UserType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FormManager
{
    private $passwordEncoder;

    private $formFactory;

    private $doctrine;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder,
                                FormFactoryInterface $formFactory,
                                RegistryInterface $doctrine
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->formFactory = $formFactory;
        $this->doctrine = $doctrine;
    }

    public function createRegisterUserForm(Request $request, User $user)
    {
        $form = $this->formFactory->create(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $wishlist = new Wishlist();
            $em = $this->doctrine->getManager();
            $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setUsername($user->getUsername());
            $user->setEmail($user->getEmail());
            $user->setPassword($password);
            $user->setRoles(array('ROLE_USER'));
            $em->persist($user);
            $wishlist->setUser($user);
            $em->persist($wishlist);
            $em->flush();

            return true;
        }

        return $form;
    }
}