<?php

namespace App\Controller;

use App\Entity\Abonne;
use Symfony\Component\Form\Forms;
use phpDocumentor\Reflection\Types\Boolean;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;   
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_panier")
     */
    public function panier()
    {
        return $this->render('user/panier.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/login", name="user_login")
     */
    public function login()
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/enregistrer", name="user_register")
     * @Route("/{id}/modifierInfos", name="modify")
     */
    public function register(Abonne $user = null, Request $request, ObjectManager $manager,
    UserPasswordEncoderInterface $encoder)
    {

        $user = new Abonne();
        $form = $this->createFormBuilder($user)
                    ->add('nomAbonne')
                    ->add('prenomAbonne')
                    ->add('email')
                    ->add('login')
                    ->add('password', PasswordType::class)
                    ->add('confirm_password', PasswordType::class)
                    ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('user_login');
        }

    return $this->render('user\register.html.twig', [
        'formRegister' => $form->createView()
    ]);
    }

}
