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
 * @Route("/albums")
 */
class AlbumController extends AbstractController
{
    /**
     * @Route("/", name="album_index")
     */
    public function index($numeroPage=null,OeuvresRepository $oeuvreRepo): Response
    {
        $numeroPage = isset($_POST['numPage'])? $_POST['numPage'] : 1;
        $filtre = isset($_POST['filtre'])? $_POST['filtre'] : "";
        $off = 0;
        if ($numeroPage != 1){
            $off = ($numeroPage-1)*10;
        }
//            $musiciens = $this->getDoctrine()->getRepository(Musicien::class)
//                ->findBy([],null,20, $off);
        $albums = $oeuvreRepo->selectAlbums($filtre,$off);
        //$nombre=$nombres/10;
        return $this->render('album/index.html.twig', [
            'albums' => $albums, 'numPage'=> $numeroPage,'filtre'=>$filtre]);
    }

    /**
     * @Route("/{codeAlbum}/images", name="album_image",methods="GET")
     */
    public function imageAlbum(Album $album): Response{
        $response = new Response();
        $response->headers->set("Content-Type","image/jpeg");
        $image=null;
        if($album->getPochette()!=null){
            $image = stream_get_contents($album->getPochette());
        }
        $response->setContent($image);
        return $response;
    }
    /**
     * @Route("/{codeAlbum}", name="album_show")
     */
    public function show(Album $album, MusicienRepository $musicienRepo,OeuvresRepository $oeuvresRepo): Response
    {
        $filtre = isset($_POST['filtre'])? $_POST['filtre'] : "";
        $numPage = isset($_POST['numPage'])? $_POST['numPage']:1;
//        $albums = array();
//
//        $albums = $oeuvresRepo->selectAlbumsEnreg($enregistrement);

        return $this->render('album/show.html.twig', ['album' => $album, 'filtre'=>$filtre,'numPage'=>$numPage/*,'albums'=>$albums*/]);
    }
}
