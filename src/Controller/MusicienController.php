<?php

namespace App\Controller;

use App\Entity\Musicien;
use App\Form\MusicienType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DomCrawler\Image;
use App\Repository\MusicienRepository;
/**
 * @Route("/musicien")
 */
class MusicienController extends AbstractController
{
    /**
     * @Route("/", name="musicien_index", methods="GET")
     */
    public function index(): Response
    {
        $musiciens = $this->getDoctrine()
            ->getRepository(Musicien::class)
            ->findBy([],null,10);

        return $this->render('musicien/index.html.twig', [
            'musiciens' => $musiciens]);
    }

    /**
     * @Route("/{codeMusicien}", name="musicien_show", methods="GET")
     */
    public function show(Musicien $musicien): Response
    {
        return $this->render('musicien/show.html.twig', ['musicien' => $musicien]);
    }

    /**
     * @Route("/{codeMusicien}/image", name="musicien_image", methods="GET")
     */
    public function image(Musicien $musicien): Response
    {
        $response = new Response();
        $response->headers->set("Content-Type","image/jpeg");
        $image = null;
        if($musicien->getPhoto()!= null) {
            $image = stream_get_contents(($musicien->getPhoto()));
        }
        $response->setContent($image);
        return $response;
    }

    /**
     * @Route("/{codeMusicien}/oeuvres", name="musicien_oeuvres", methods="GET")
     */
    public function oeuvres(Musicien $musicien): Response
    {
        $response = new Response();
        return $response;
    }


//    public function filtreMusicien($musicien){
//        $em = $this->getDoctrine()->getManager();
//        $data=$em->getRepository(Musicien :: class)->findAll();
//        $sql = $em->
//    }
}
