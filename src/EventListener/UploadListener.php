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

    /** @var User|null */
    private $user;

    public function __construct(PhotoManager $photoManager, TokenStorageInterface $tokenStorage)
    {
        $this->photoManager = $photoManager;
        $this->user = $tokenStorage->getToken() ? $tokenStorage->getToken()->getUser() : null;
    }

    public function onUpload(PostPersistEvent $event)
    {
        $response = $event->getResponse();
        $response['success'] = false;
        if (!$this->user) {
            return $response;
        }

        /** @var File $file */
        $file = $event->getFile();
        $photo = $this->photoManager->getNew()
            ->setFileName($file->getFilename())
            ->setUploadedBy($this->user);
        $this->photoManager->save($photo);

        $response['success'] = true;

        return $response;
    }
}
