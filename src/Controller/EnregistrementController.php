<?php

namespace App\Controller;


use App\Entity\Musicien;
use App\Entity\Oeuvre;
use App\Entity\Album;
use App\Entity\Enregistrement;
use App\Form\MusicienType;
use App\Repository\OeuvresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DomCrawler\Image;
use App\Repository\MusicienRepository;

/**
 * @Route("/enregistrement")
 */
class EnregistrementController extends AbstractController
{
    /**
     * @Route("/", name="enregistrement")
     */
    public function index($numeroPage = null, OeuvresRepository $oeuvreRepo): Response
    {
        $numeroPage = isset($_POST['numPage']) ? $_POST['numPage'] : 1;
        $filtre = isset($_POST['filtre']) ? $_POST['filtre'] : "";
        $off = 0;
        if ($numeroPage != 1) {
            $off = ($numeroPage - 1) * 10;
        }
//            $musiciens = $this->getDoctrine()->getRepository(Musicien::class)
//                ->findBy([],null,20, $off);
        $enregistrements = $oeuvreRepo->selectEnreg($filtre, $off);
        //$nombre=$nombres/10;
        return $this->render('enregistrement/index.html.twig', [
            'enregistrements' => $enregistrements, 'numPage' => $numeroPage, 'filtre' => $filtre]);
    }

    /**
     * @Route("/{codeMorceau}", name="enregistrement_show")
     */
    public function show(Enregistrement $enregistrement, MusicienRepository $musicienRepo, OeuvresRepository $oeuvresRepo): Response
    {
        $filtre = isset($_POST['filtre']) ? $_POST['filtre'] : "";
        $numPage = isset($_POST['numPage']) ? $_POST['numPage'] : 1;
//        $albums = array();

        $albums = $oeuvresRepo->selectAlbumsEnreg($enregistrement);

        return $this->render('enregistrement/show.html.twig', ['enregistrement' => $enregistrement, 'filtre' => $filtre, 'numPage' => $numPage, 'albums' => $albums]);
    }

    /**
     * @Route("/{codeMorceau}/enregistrement", name="enregistrement_audio", methods="GET")
     */
    public function enregistrementAudio(Enregistrement $enregistrement): Response
    {
        $response = new Response();
        $response->headers->set("Content-Type", "audio/mp3");
        $audio = null;
        if ($enregistrement->getExtrait() != null) {
            $audio = (stream_get_contents($enregistrement->getExtrait()));
        }
        $response->setContent($audio);
        return $response;

    }


    /**
     * @Route("/{codeAlbum}/images", name="enregistrement_image_album",methods="GET")
     */
    public function imageAlbum(Album $album): Response
    {
        $response = new Response();
        $response->headers->set("Content-Type", "image/jpeg");
        $image = null;
        if ($album->getPochette() != null) {
            $image = stream_get_contents($album->getPochette());
        }
        $response->setContent($image);
        return $response;
    }

}
