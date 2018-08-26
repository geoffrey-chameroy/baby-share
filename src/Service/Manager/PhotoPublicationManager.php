<?php

namespace App\Service\Manager;

use App\Entity\PhotoPublication;
use App\Repository\PhotoPublicationRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method PhotoPublicationRepository getRepository()
 * @method PhotoPublication           getNew()
 * @method PhotoPublication|null      get(int $id, bool $check = true)
 * @method PhotoPublication           save(PhotoPublication $PhotoPublication)
 * @method void                       remove(PhotoPublication $PhotoPublication)
 * @method void                       checkEntity(?PhotoPublication $PhotoPublication)
 */
class PhotoPublicationManager extends AbstractEntityManager
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, PhotoPublication::class);
    }

    /**
     * @return PhotoPublication[]
     */
    public function getList(): array
    {
        return $this->getRepository()->findBy(
            [],
            ['publishedAt' => 'desc']
        );
    }

    public function getLast(): ?PhotoPublication
    {
        return $this->getRepository()->getLast();
    }
}
