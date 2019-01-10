<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use phpDocumentor\Reflection\Types\Boolean;
use App\Entity\Abonne;
use Symfony\Component\HttpFoundation\Request;   
use Symfony\Component\Form\Forms;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @Route("/panier")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier")
     */
    public function panier()
    {
        return $this->render('panier/panier.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion()
    {
        return $this->render('panier/connexion.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

    /**
     * @Route("/enregistrer", name="register")
     * @Route("/{id}/modifierInfos", name="modify")
     */
    public function register(Abonne $user = null, Request $request, ObjectManager $manager)
    {

        $user = new Abonne();
        $form = $this->createFormBuilder($user)
                    ->add('nomAbonne')
                    ->add('prenomAbonne')
                    ->add('login')
                    ->add('password')
                    ->add('register', SubmitType::class, [
                        'label' => "S'enregistrer"
                    ])
                    ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home_main');
        }

    return $this->render('panier\register.html.twig', [
        'formRegister' => $form->createView()
    ]);
    }

    /**
     * @Route("/?", name="test_login")
     */
    public function testLogin($login)
    {
        
    }
}
