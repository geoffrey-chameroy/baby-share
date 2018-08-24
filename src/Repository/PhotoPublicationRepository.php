<?php

namespace App\Repository;

use App\Entity\PhotoPublication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PhotoPublication|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoPublication|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoPublication[]    findAll()
 * @method PhotoPublication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoPublicationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PhotoPublication::class);
    }

    public function getLast(): ?PhotoPublication
    {
        return $this->createQueryBuilder('pb')
            ->addOrderBy('pb.id', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
