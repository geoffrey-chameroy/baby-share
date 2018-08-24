<?php

namespace App\EventListener;

use App\Entity\User;
use App\Service\Manager\PhotoManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UploadListener
{
    /** @var PhotoManager */
    private $photoManager;

    /** @var User */
    private $user;

    public function __construct(PhotoManager $photoManager, TokenStorageInterface $tokenStorage)
    {
        $this->photoManager = $photoManager;
        $this->user = $tokenStorage->getToken()->getUser();
    }

    public function onUpload(PostPersistEvent $event)
    {
        /** @var File $file */
        $file = $event->getFile();
        $photo = $this->photoManager->getNew()
            ->setFileName($file->getFilename())
            ->setUploadedBy($this->user);
        $this->photoManager->save($photo);

        $response = $event->getResponse();
        $response['success'] = true;

        return $response;
    }
}
