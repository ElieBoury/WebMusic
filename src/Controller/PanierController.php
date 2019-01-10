<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use phpDocumentor\Reflection\Types\Boolean;
use App\Entity\Abonne;
use Symfony\Component\HttpFoundation\Request;   
use Symfony\Component\Form\Forms;
use Doctrine\Common\Persistence\ObjectManager;

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
     */
    public function register(Request $request, ObjectManager $manager)
    {
        $user = new Abonne();
        $form = $this->createFormBuiler($user)
                    ->add('name')
                    ->add('surname')
                    ->add('login')
                    ->add('password')
                    ->getForm();

        $manager->persist($user);
        $manager->flush();

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
