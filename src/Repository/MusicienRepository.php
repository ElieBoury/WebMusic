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


    public function selectAll(){
        $em = $this->getEntityManager()->createQuery('SELECT * FROM Musicien FETCH 10 NEXT ROWS ONLY')->getResult();

    }

    public function selectOeuvres(Musicien $musicien){
        $em=$this->getEntityManager();
        $codeM = $musicien->getCodeMusicien();
        $sql = "Select * From Oeuvre
              inner join Composer ON Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
              Where Code_Musicien = $codeM";
        $stmt = $em->getConnection()->prepare($sql)/*->(':musicien',$musicien->getCodeMusicien())*/;
        $stmt->execute();
        return $stmt->fetchAll();

    }
    public function selectAlbums(Musicien $musicien){
        $em=$this->getEntityManager();
        $codeM = $musicien->getCodeMusicien();
        $sql="Select * from Album join Genre on Genre.Code_Genre = Album.Code_Genre
inner join Musicien on Genre.Code_Genre = Musicien.Code_Genre
Where Musicien.Code_Musicien = $codeM"   ;
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}