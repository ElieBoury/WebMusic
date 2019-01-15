<?php

namespace App\Controller;

use App\Entity\Abonne;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_home", methods="GET")
     */
    public function home()
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/a_propos", name="home_a_propos")
     */
    public function a_propos()
    {
        return $this->render('home/a_propos.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/{codeAbonne}/mon_compte", name="home_compte")
     */
    public function compte(Abonne $abonne)
    {
        $codeAbonne = $abonne->getCodeAbonne();

        return $this->render('home/compte.html.twig', [
            'controller_name' => 'HomeController',
            'codeAbonne' => $codeAbonne 
        ]);
    }
}
