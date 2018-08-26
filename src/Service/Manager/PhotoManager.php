<?php

namespace App\Service\Manager;

use App\Entity\Photo;
use App\Entity\PhotoPublication;
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
class PhotoManager extends AbstractEntityManager
{
    public function __construct(EntityManagerInterface $em)
    {
         parent::__construct($em, Photo::class);
    }

    /**
     * @param PhotoPublication $publication
     * @return Photo[]
     */
    public function getByPublication(PhotoPublication $publication)
    {
        return $this->getRepository()->findBy(['publication' => $publication]);
    }

    /**
     * @return Photo[]
     */
    public function getNonPublished()
    {
        return $this->getRepository()->findBy(['publication' => null]);
    }

    /**
     * @param PhotoPublication $publication
     * @return Photo[]
     */
    public function publish(PhotoPublication $publication)
    {
        $photos = $this->getRepository()->findBy(['publication' => null]);
        foreach ($photos as $photo) {
            $photo->setPublication($publication);
            $this->save($photo);
        }

        return $photos;
    }
}
