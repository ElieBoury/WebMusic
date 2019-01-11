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
            parent::__construct($registry);
        }
}