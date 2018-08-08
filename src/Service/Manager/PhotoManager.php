<?php

namespace App\Service\Manager;

use App\Entity\Photo;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method PhotoRepository getRepository()
 * @method Photo           getNew()
 * @method Photo|null      get(int $id, bool $check = true)
 * @method Photo[]         getList()
 * @method Photo           save(Photo $photo)
 * @method void            remove(Photo $photo)
 * @method void            checkEntity(?Photo $photo)
 */
class PhotoManager extends EntityManager
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Photo::class);
    }

    /**
     * @return Photo[]
     */
    public function getPublished()
    {
        return $this->getRepository()->getPublished();
    }
}
