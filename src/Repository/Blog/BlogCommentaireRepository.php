<?php

namespace App\Repository\Blog;

use App\Entity\Blog\BlogCommentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BlogCommentaire>
 *
 * @method BlogCommentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogCommentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogCommentaire[]    findAll()
 * @method BlogCommentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogCommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogCommentaire::class);
    }

    public function add(BlogCommentaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BlogCommentaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BlogCommentaire[] Returns an array of BlogCommentaire objects
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

//    public function findOneBySomeField($value): ?BlogCommentaire
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
