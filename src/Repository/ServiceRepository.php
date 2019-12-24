<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function myFind()
    {
        $qb = $this->createQueryBuilder('service');
     
        $query=$qb->getQuery();
        $rs=$query->getResult();
        return $rs;
    }

    public function findByLib($lib)
    {
        $qb=$this->createQueryBuilder('SERVICE');
        $qb->where('SERVICE.libelle= :libelle');
        $qb->setParameter('libelle', $lib);
        $query=$qb->getQuery();
        $rs=$query->getResult();
        return $rs;
    }

    public function dQl()
    {
        $query=$this->_em->createQuery('SELECT l.libelle FROM App\Entity\Service l');
        $rs=$query->getResult();
        return $rs;
    }

    public function getBySeerv()
    {
        $qb=$this->createQueryBuilder('service')
            ->leftJoin('service.medecins','medecin')
            ->addSelect('medecin')
            ->getQuery()->getResult();
            return $qb;
    }

    public function getByservCond($id)
    {
        $qb=$this->createQueryBuilder('service')
            ->leftJoin('service.medecins','medecin' )
            ->addSelect('medecin')
            ->innerJoin('service.medecins','medecins','with','service.id=medecin.id');
            //where($qb->expr()->in('service.id=medecin.service_id', $id));
        //$qb->andWhere('service.id=:id')
           //->setParameter('id',$id)
        $qb->getQuery()->getResult();
        return $qb;
    }
    // /**
    //  * @return Service[] Returns an array of Service objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Service
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
