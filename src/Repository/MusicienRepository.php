<?php
/**
 * Created by PhpStorm.
 * User: tlavergne
 * Date: 10/01/19
 * Time: 16:40
 */

namespace App\Repository;

use App\Entity\Musicien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\EntityRepository;

class MusicienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Musicien::class);
    }


    public function selectAllCount(){
    $em = $this->getEntityManager();
    $sql ="Select Count(*) from Musicien";
    $stmt = $em->getConnection()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
    }
    public function selectFilter($filtre){
        $em = $this->getEntityManager();
       //OFFSET 5 ROWS FETCH NEXT 10 ROWS ONLY
      //  $stmt = $em->getConnection()->query("Select * from Musicien where Nom_Musicien like 'nom'  ");/* FETCH 10 NEXT ROWS ONLY*/
        $rsn = new ResultSetMappingBuilder($em);
        $rsn->addRootEntityFromClassMetadata(Musicien::class,'Musicien');
        $sql = "Select * from Musicien where Nom_Musicien like :filtre ";
        $query=$em->createNativeQuery($sql,$rsn);
        $query->setParameter(':filtre',$filtre.'%');
        $query->execute();
        return $query->getResult();
    }

    public function selectOeuvres(Musicien $musicien){
        $em=$this->getEntityManager();
        $codeM = $musicien->getCodeMusicien();
        $sql =         "Select * From Oeuvre
              inner join Composer ON Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
              Where Code_Musicien = $codeM";
        $stmt = $em->getConnection()->prepare($sql)/*->(':musicien',$musicien->getCodeMusicien())*/;
        $stmt->execute();
        return $stmt->fetchAll();

    }

}