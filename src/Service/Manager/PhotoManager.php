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
class PhotoManager extends AbstractEntityManager
{
    /** @var PhotoPublicationManager */
    private $photoPublicationManager;

    public function __construct(EntityManagerInterface $em, PhotoPublicationManager $photoPublicationManager)
    {
        $this->photoPublicationManager = $photoPublicationManager;

        parent::__construct($em, Photo::class);
    }

    /**
     * @return Photo[]
     */
    public function getPublished()
    {
        return $this->getRepository()->getPublished();
    }

    /**
     * @return Photo[]
     */
    public function getLastPublished()
    {
        $publication = $this->photoPublicationManager->getLast();

        return $this->getRepository()->findBy(['publication' => $publication]);
    }
}
