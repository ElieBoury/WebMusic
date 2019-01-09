<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/a_propos")
 */
class AProposController extends AbstractController
{
    /**
     * @Route("/", name="a_propos_index")
     */
    public function index()
    {
        return $this->render('a_propos/index.html.twig', [
            'controller_name' => 'AProposController',
        ]);
    }
}
