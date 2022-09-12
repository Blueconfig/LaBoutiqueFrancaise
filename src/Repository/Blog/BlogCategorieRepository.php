<?php

namespace App\Repository\Blog;

use App\Entity\Blog\BlogCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BlogCategorie>
 *
 * @method BlogCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogCategorie[]    findAll()
 * @method BlogCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogCategorie::class);
    }

    public function add(BlogCategorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BlogCategorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BlogCategorie[] Returns an array of BlogCategorie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BlogCategorie
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
