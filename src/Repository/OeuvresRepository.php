<?php
/**
 * Created by PhpStorm.
 * User: tlavergne
 * Date: 10/01/19
 * Time: 20:07
 */

namespace App\Repository;

use App\Entity\Oeuvre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\EntityRepository;

class OeuvresRepository extends ServiceEntityRepository
{
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry,Oeuvre::class);
        }
    public function selectAlbums(Oeuvre $oeuvre){
        $em=$this->getEntityManager();
        $codeO = $oeuvre->getCodeOeuvre();
        $sql="Select * from Album
inner join Disque on Disque.Code_Album = Album.Code_Album
inner join Composition_Disque on Composition_Disque.Code_Disque = Disque.Code_Disque
inner join Interpreter on Composition_Disque.Code_Morceau = Interpreter.Code_Morceau
inner join Instrumentation on Interpreter.Code_Instrument = Instrumentation.Code_Instrument
where Instrumentation.Code_Oeuvre = $codeO"   ;
        $stmt = $em->getConnection()->prepare($sql);;
        $stmt->execute();
        return $stmt->fetchAll();
    }
}