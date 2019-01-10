<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_main", methods="GET")
     */
    public function home()
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/a_propos", name="a_propos_main")
     */
    public function a_propos()
    {
        return $this->render('home/a_propos.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/mon_compte", name="compte")
     */
    public function compte()
    {
        return $this->render('home/compte.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
