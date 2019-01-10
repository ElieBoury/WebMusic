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
}