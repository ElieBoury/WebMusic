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

class OeuvresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Oeuvre::class);
    }

    public function selectAlbums(Oeuvre $oeuvre)
    {
        $em = $this->getEntityManager();
        $codeO = $oeuvre->getCodeOeuvre();
        $sql = "Select * from Album
inner join Disque on Disque.Code_Album = Album.Code_Album
inner join Composition_Disque on Composition_Disque.Code_Disque = Disque.Code_Disque
inner join Interpreter on Composition_Disque.Code_Morceau = Interpreter.Code_Morceau
inner join Instrumentation on Interpreter.Code_Instrument = Instrumentation.Code_Instrument
inner join Composer on Instrumentation.Code_Oeuvre = Composer.Code_Oeuvre
where Composer.Code_Musicien = $codeO";
        $stmt = $em->getConnection()->prepare($sql);;
        $stmt->execute();
        return $stmt->fetchAll();
    }

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
    public function selectAllEnreg(){
        $em= $this->getEntityManager();
        $sql="Select * from Enregistrement";
        $stmt=$em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
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