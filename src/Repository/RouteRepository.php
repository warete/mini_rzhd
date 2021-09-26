<?php

namespace App\Repository;

use App\Entity\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Route|null find($id, $lockMode = null, $lockVersion = null)
 * @method Route|null findOneBy(array $criteria, array $orderBy = null)
 * @method Route[]    findAll()
 * @method Route[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Route::class);
    }

    // /**
    //  * @return Route[] Returns an array of Route objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Route
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

	/**
	 * @param int $stationFromId
	 * @param int $stationToId
	 * @return Route|null
	 */
	public function findByStationsInDates(int $stationFromId, int $stationToId, $dateFrom, $dateEnd)
	{
		return $this->createQueryBuilder('r')
			->where('r.station_from = :station_from')
			->andWhere('r.station_to = :station_to')
			->andWhere('r.date_start >= :date_start')
			->andWhere('r.date_end <= :date_end')
			->setParameter('station_from', $stationFromId)
			->setParameter('station_to', $stationToId)
			->setParameter('date_start', $dateFrom)
			->setParameter('date_end', $dateEnd)
			->getQuery()
			->getResult();
	}
}
