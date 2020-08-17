<?php

namespace App\Repository;

use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Search|null find($id, $lockMode = null, $lockVersion = null)
 * @method Search|null findOneBy(array $criteria, array $orderBy = null)
 * @method Search[]    findAll()
 * @method Search[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Search::class);
    }

    // /**
    //  * @return Search[] Returns an array of Search objects
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
    public function findOneBySomeField($value): ?Search
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @param string $string
     * @return Search Returns a search object
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getSearch(string $string)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.search_text = :val')
            ->setParameter('val', $string)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }


    /**
     * @param int $max
     * @return \Doctrine\ORM\Query Returns an array of Search objects
     */
    public function getSearchesBySearchTimes(int $max)
    {
        $object =  $this->createQueryBuilder('s')
            ->orderBy('s.search_times', 'DESC');
        if($max != 0)
            return $object->setMaxResults($max)
                ->getQuery();
        else
            return $object->getQuery();
    }

    /**
     * @param int $max
     * @return \Doctrine\ORM\Query Returns an array of Search objects
     */
    public function getSearchesByLatest(int $max)
    {
        $object = $this->createQueryBuilder('s')
            ->orderBy('s.id', 'DESC')
            ->addOrderBy('s.search_times', 'DESC');
        if($max != 0)
            return $object->setMaxResults($max)
                ->getQuery();
        else
            return $object->getQuery();
    }

    /**
     * @param int $start
     * @param int $limit
     * @return Search[] Returns an array of Search objects
     */
    public function getSearchSiteMap(int $start, int $limit)
    {
        return $this->createQueryBuilder('s')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $start
     * @param int $stopAt
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     */
    public function getNumberOfRowsForNewSiteMap(int $start, int $stopAt){
        try {
            return $this->createQueryBuilder('s')
                ->select('count(s.id)')
                ->andWhere('s.id > :val')
                ->setParameter('val', $start)
                ->setMaxResults($stopAt)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return $e->getMessage();
        }
    }
}
