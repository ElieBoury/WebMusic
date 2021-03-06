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
 * @Route("/musicien")
 */
class MusicienController extends AbstractController
{//#{numeroPage}
    /**
     * @Route("/", name="musicien_index")
     */
    public function index($numeroPage=null,MusicienRepository $musicienRepo): Response
            {
            $numeroPage = isset($_POST['numPage'])? $_POST['numPage'] : 1;
            $filtre = isset($_POST['filtre'])? $_POST['filtre'] : "";
            $off = 0;
            if ($numeroPage != 1){
                $off = ($numeroPage-1)*20;
            }
//            $musiciens = $this->getDoctrine()->getRepository(Musicien::class)
//                ->findBy([],null,20, $off);
            $musiciens = $musicienRepo->selectFilter($filtre,$off);
        $nombre = $musicienRepo->selectAllCount();
        //$nombre=$nombres/10;
        return $this->render('musicien/index.html.twig', [
            'musiciens' => $musiciens, 'nombres'=>$nombre,'numPage'=> $numeroPage,'filtre'=>$filtre]);
    }
//    /**
//     * @Route("/#", name="musicien_indexF")
//     */
//    public function indexFilter(Request $request, MusicienRepository $musicienRepo): Response{
//        //$filtre = $request->get($_POST)['filtre'];
//            $filtre = $_POST['filtre'];
//        $musiciens= $musicienRepo->selectFilter($filtre);
//        $nbMusiciensF = $musicienRepo->selectAllCountFilter($filtre);
//        return $this->render('musicien/index.html.twig', ['musiciens'=>$musiciens, 'numPage'=>$nbMusiciensF]);
//    }
    /**
     * @Route("/oeuvres", name="oeuvres", methods="GET")
     */
    public function listeOeuvres(OeuvresRepository $oeuvresRepo){
        $oeuvres=$oeuvresRepo->listeOeuvres();
        return $this->render('musicien/listeoeuvres.html.twig',['oeuvres'=>$oeuvres]);
    }

    /**
     * @Route("/{codeMusicien}", name="musicien_show")
     */
    public function show(Musicien $musicien, MusicienRepository $musicienRepo,OeuvresRepository $oeuvresRepo): Response
    {
        $filtre = isset($_POST['filtre'])? $_POST['filtre'] : "";
        $numPage = isset($_POST['numPage'])? $_POST['numPage']:1;
        $oeuvres = $musicienRepo->selectOeuvres($musicien);
//        $albums = array();
//        foreach($oeuvres as $oeu=>$oeuvre) {
//
//            $albums[$oeu] = $oeuvresRepo->selectAlbumsEnregistrements($oeuvre);
//        }
        return $this->render('musicien/show.html.twig', ['musicien' => $musicien, 'filtre'=>$filtre,'numPage'=>$numPage/*,'albums'=>$albums*/]);
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
    public function oeuvres(Musicien $musicien, MusicienRepository $musicienRepo): Response
    {
        $oeuvres=$musicienRepo->selectOeuvres($musicien);
        return $this->render('musicien/oeuvres.html.twig',['musicien'=>$musicien,'oeuvres'=> $oeuvres]);
    }
    /**
     * @Route("/{codeMusicien}/oeuvres/{codeOeuvre}", name="musicien_oeuvres_show", methods="GET")
     */
    public function showOeuvres(Musicien $musicien,Oeuvre $oeuvre, OeuvresRepository $oeuvresRepo){
    //    $albums=$oeuvresRepo->selectAlbums($oeuvre);
      //  $enregistrements =$oeuvresRepo->selectEnregistrements($oeuvre);
        $enregistrements = $oeuvresRepo->selectEnregistrements($oeuvre);
//        foreach($enregistrements as $enregistrement){
//            $albums = $oeuvresRepo->selectAlbumsEnreg($enregistrement);
//        }
        $albums = $oeuvresRepo->selectAlbumsEnregistrements($oeuvre);
        return $this->render('musicien/showOeuvre.html.twig', ['oeuvre'=> $oeuvre, 'albums'=>$albums, 'enreg'=>$enregistrements]);
    }
    /**
     * @Route("/{codeAlbum}/images", name="musicien_image_album",methods="GET")
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
     * @Route("/{codeMorceau}/enregistrement", name="musicien_enregistrement_audio", methods="GET")
     */
    public function enregistrementAudio(Enregistrement $enregistrement) : Response{
        $response = new Response();
        $response->headers->set("Content-Type","audio/mp3");
        $audio = null;
        if ($enregistrement->getExtrait()!=null){
            $audio = (stream_get_contents($enregistrement->getExtrait()));
        }
        $response->setContent($audio);
        return $response;

    }

}
