<?php
/**
 * Created by PhpStorm.
 * User: tlavergne
 * Date: 14/01/19
 * Time: 22:43
 */

namespace App\Repository;

use App\Entity\Abonne;
use App\Entity\Achat;
use App\Entity\Enregistrement;
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
    $rsn->addRootEntityFromClassMetadata(Achat::class,'Achat');
    $sql = "Select Achat.* from Achat 
inner join Abonne on Achat.Code_Abonne = Abonne.Code_Abonne
where Achat_Confirme=0 and Abonne.Code_Abonne = :abonne";
    $query=$em->createNativeQuery($sql,$rsn);
    $query->setParameter(':abonne',$abonne->getCodeAbonne());
    $query->execute();
    return $query->getResult();
}
public function titreEnregistrementAchat(Abonne $abonne){
    $em = $this->getEntityManager();
    $rsn = new ResultSetMappingBuilder($em);
    $rsn->addRootEntityFromClassMetadata(Enregistrement::class,'Achat');
    $sql="Select Distinct * from Enregistrement 
inner join Achat on Achat.Code_Enregistrement = Enregistrement.Code_Morceau
where Achat.Code_Abonne = :abonne and Achat.Achat_Confirme =0";
    $query = $em->createNativeQuery($sql,$rsn);
    $query->setParameter(':abonne', $abonne->getCodeAbonne());
    $query->execute();
    return $query->getResult();
}
public function enregistrementAchat(Achat $achat){
    $em=$this->getEntityManager();
    $rsn = new ResultSetMappingBuilder($em);
    $rsn->addRootEntityFromClassMetadata(Enregistrement::class,'Achat');
    $sql="Select Distinct * from Enregistrement 
inner join Achat on Achat.Code_Enregistrement = Enregistrement.Code_Morceau
where Achat.Code_Achat = :achat and Achat.Achat_Confirme =0";
    $query = $em->createNativeQuery($sql,$rsn);
    $query->setParameter(':achat', $achat->getCodeAchat());
    $query->execute();
    return $query->getResult();
}


    public function achatsPrecedents(Abonne $abonne){
        $em=$this->getEntityManager();
        $rsn = new ResultSetMappingBuilder($em);
        $rsn->addRootEntityFromClassMetadata(Enregistrement::class,'Achat');
        $sql="Select Distinct * from Enregistrement 
inner join Achat on Achat.Code_Enregistrement = Enregistrement.Code_Morceau
where Achat.Code_Abonne = :abonne and Achat.Achat_Confirme =1";
        $query = $em->createNativeQuery($sql,$rsn);
        $query->setParameter(':abonne', $abonne->getCodeAbonne());
        $query->execute();
        return $query->getResult();
    }
    public function titreEnregistrementAchatPrec(Abonne $abonne){
        $em = $this->getEntityManager();
        $rsn = new ResultSetMappingBuilder($em);
        $rsn->addRootEntityFromClassMetadata(Enregistrement::class,'Achat');
        $sql="Select Distinct * from Enregistrement 
inner join Achat on Achat.Code_Enregistrement = Enregistrement.Code_Morceau
where Achat.Code_Abonne = :abonne and Achat.Achat_Confirme =1";
        $query = $em->createNativeQuery($sql,$rsn);
        $query->setParameter(':abonne', $abonne->getCodeAbonne());
        $query->execute();
        return $query->getResult();
    }


    public function acheterEnregistrements(Abonne $abonne){
    $em = $this->getEntityManager();
    $codeA = $abonne->getCodeAbonne();
    $sql ="UPDATE Achat SET Achat_Confirme=1  where Achat.Code_Abonne = $codeA";
    $stmt =$em->getConnection()->prepare($sql);
    $stmt->execute();
    $em->flush();
    }
}