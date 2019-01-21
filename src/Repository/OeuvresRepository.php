<?php
/**
 * Created by PhpStorm.
 * User: tlavergne
 * Date: 10/01/19
 * Time: 20:07
 */

namespace App\Repository;

use App\Entity\Oeuvre;
use App\Entity\Enregistrement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\EntityRepository;
use App\Entity\Album;
use App\Entity\Abonne;
class OeuvresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Oeuvre::class);
    }

    public function selectAlbums($filtre,$off){
        $em = $this->getEntityManager();
        //OFFSET 5 ROWS FETCH NEXT 10 ROWS ONLY
        //  $stmt = $em->getConnection()->query("Select * from Musicien where Nom_Musicien like 'nom'  ");/* FETCH 10 NEXT ROWS ONLY*/
        $rsn = new ResultSetMappingBuilder($em);
        $rsn->addRootEntityFromClassMetadata(Album::class,'Album');
        $sql = "Select * from Album where Titre_Album like :filtre ORDER BY Code_Album OFFSET :off ROWS FETCH NEXT 10 ROWS ONLY";
        $query=$em->createNativeQuery($sql,$rsn);
        $query->setParameter(':filtre',$filtre.'%');
        $query->setParameter(':off',$off);
        $query->execute();
        return $query->getResult();
    }
//    public function AjoutPanier(Abonne $abonne,Enregistrement $enregistrement){
//        $em = $this->getEntityManager();
//        $codeA = $abonne->getCodeAbonne();
//        $codeE = $enregistrement->getCodeMorceau();
//        $sql = "INSERT into Achat values ($codeE,$codeA,0)";
//        $stmt=$em->getConnection()->prepare($sql);
//        $stmt->
//
//    }
    public function selectEnregistrements(Oeuvre $oeuvre)
    {
        $em = $this->getEntityManager();
        $codeO = $oeuvre->getCodeOeuvre();
        $sql = "
Select Distinct Enregistrement.Nom_de_Fichier, Enregistrement.*   from Musicien
inner join Interpreter on Musicien.Code_Musicien = Interpreter.Code_Musicien
inner join Enregistrement on Interpreter.Code_Morceau = Enregistrement.Code_Morceau
inner join Composition_Oeuvre on Composition_Oeuvre.Code_Composition = Enregistrement.Code_Composition
where Composition_Oeuvre.Code_Oeuvre = $codeO";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function selectEnreg($filtre,$off){
        $em = $this->getEntityManager();
        //OFFSET 5 ROWS FETCH NEXT 10 ROWS ONLY
        //  $stmt = $em->getConnection()->query("Select * from Musicien where Nom_Musicien like 'nom'  ");/* FETCH 10 NEXT ROWS ONLY*/
        $rsn = new ResultSetMappingBuilder($em);
        $rsn->addRootEntityFromClassMetadata(Enregistrement::class,'Enregistrement');
        $sql = "Select * from Enregistrement where Titre like :filtre ORDER BY Code_Morceau OFFSET :off ROWS FETCH NEXT 10 ROWS ONLY";
        $query=$em->createNativeQuery($sql,$rsn);
        $query->setParameter(':filtre',$filtre.'%');
        $query->setParameter(':off',$off);
        $query->execute();
        return $query->getResult();
    }
    public function selectAlbumsEnreg(Enregistrement $enregistrement)
    {
        $em = $this->getEntityManager();
        $codeE = $enregistrement->getCodeMorceau();
        $sql = " Select Album.* from Album 
inner join Disque on Album.Code_Album = Disque.Code_Album
inner join Composition_Disque on Disque.Code_Disque = Composition_Disque.Code_Disque
inner join Enregistrement on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
where Enregistrement.Code_Morceau = $codeE";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function selectAlbumsEnregistrements(Oeuvre $oeuvre)
    {
        $em = $this->getEntityManager();
        $codeO = $oeuvre->getCodeOeuvre();
        $sql = "Select DISTINCT Album.Pochette, Album.Code_Album from Album
inner join Disque on Album.Code_Album = Disque.Code_Album
inner join Composition_Disque on Disque.Code_Disque = Composition_Disque.Code_Disque
inner join Enregistrement on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
inner join Composition_Oeuvre on Enregistrement.Code_Composition = Composition_Oeuvre.Code_Composition
where Composition_Oeuvre.Code_Oeuvre =  $codeO";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}