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
 * @method void            checkEntity(?Photo $photo)
 */
class PhotoManager extends AbstractEntityManager
{
    const WEB_WIDTH = 1600;
    const WEB_HEIGHT = 1600;

    const THUMB_WIDTH = 640;
    const THUMB_HEIGHT = 480;

    const NB_PER_PAGE = 10;

    public function __construct(EntityManagerInterface $em)
    {
         parent::__construct($em, Photo::class);
    }

    /**
     * @param PhotoPublication|null $publication
     * @return Photo[]
     */
    public function getByPublication(?PhotoPublication $publication)
    {
        return $this->getRepository()->findBy([
            'publication' => $publication,
            'deletedAt' => null,
        ]);
    }

    /**
     * @return Photo[]
     */
    public function getUnPublished()
    {
        return $this->getRepository()->findBy([
            'publication' => null,
            'deletedAt' => null,
        ]);
    }

    /**
     * @param PhotoPublication $publication
     * @return Photo[]
     */
    public function publish(PhotoPublication $publication)
    {
        $photos = $this->getRepository()->findBy([
            'publication' => null,
            'deletedAt' => null,
        ]);

        foreach ($photos as $photo) {
            $photo->setPublication($publication);
            $this->save($photo);
        }

        return $photos;
    }

    /**
     * @param int $page
     * @return Photo[]
     */
    public function getListPerPage(int $page = 1)
    {
        $page = $page >= 1 ? $page : 1;
        $offset = ($page - 1) * self::NB_PER_PAGE;

        return $this->getRepository()->findBy(
            [],
            ['id' => 'desc'],
            self::NB_PER_PAGE,
            $offset
        );
    }

    public function getNbPage(): int
    {
        return ceil(count($this->getRepository()->findAll()) / self::NB_PER_PAGE);
    }

    /**
     * @param Photo $photo
     */
    public function remove($photo): void
    {
        $photo->setDeletedAt(new \DateTime());
        $photo->setPublication(null);
        $this->save($photo);
    }

    public function restore(Photo $photo): Photo
    {
        $photo->setDeletedAt(null);
        $photo->setPublication(null);
        $this->save($photo);

        return $photo;
    }
}
