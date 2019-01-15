<?php
/**
 * Created by PhpStorm.
 * User: tlavergne
 * Date: 14/01/19
 * Time: 22:43
 */

namespace App\Repository;

use App\Entity\Abonne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\EntityRepository;


class AbonneRepository extends ServiceEntityRepository
{
public function __construct(ManagerRegistry $registry)
{
    parent::__construct($registry, Abonne :: class);
}

public function achatsNonConfirmes(Abonne $abonne){
    $em = $this->getEntityManager();
    //OFFSET 5 ROWS FETCH NEXT 10 ROWS ONLY
    //  $stmt = $em->getConnection()->query("Select * from Musicien where Nom_Musicien like 'nom'  ");/* FETCH 10 NEXT ROWS ONLY*/
    $rsn = new ResultSetMappingBuilder($em);
    $rsn->addRootEntityFromClassMetadata(Abonne::class,'Abonne');
    $sql = "Select * from Achat 
inner join Abonne on Achat.Code_Abonne = Abonne.Code_Abonne
where Achat_Confirme=0 and Abonne.Code_Abonne = :abonne";
    $query=$em->createNativeQuery($sql,$rsn);
    $query->setParameter(':abonne',$abonne->getCodeAbonne());
    $query->execute();
    return $query->getResult();
}

}