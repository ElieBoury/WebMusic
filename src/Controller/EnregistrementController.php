<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EnregistrementController extends AbstractController
{
    /**
     * @Route("/enregistrement", name="enregistrement")
     */
    public function index()
    {
        return $this->render('enregistrement/index.html.twig', [
            'controller_name' => 'EnregistrementController',
        ]);
    }
}
