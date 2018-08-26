<?php

namespace App\EventListener;

use App\Entity\User;
use App\Service\Manager\PhotoManager;
use Intervention\Image\ImageManagerStatic as ImageManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UploadListener
{
    /** @var KernelInterface */
    private $kernel;

    /** @var PhotoManager */
    private $photoManager;

    /** @var User|null */
    private $user;

    public function __construct(KernelInterface $kernel, PhotoManager $photoManager, TokenStorageInterface $tokenStorage)
    {
        $this->kernel = $kernel;
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
            ->setOriginal($file->getFilename())
            ->setUploadedBy($this->user);

        $folder = $this->kernel->getRootDir() . '/../uploads';
        dump($folder . '/' . $photo->getOriginal());
        $web = $this->generateFileName();
        ImageManager::make($folder . '/' . $photo->getOriginal())
            ->widen(PhotoManager::WEB_WIDTH)
            ->save($folder . '/' . $web);
        $photo->setWeb($web);

        $thumb = $this->generateFileName();
        ImageManager::make($folder . '/' . $photo->getOriginal())
            ->fit(PhotoManager::THUMB_WIDTH, PhotoManager::THUMB_HEIGHT)
            ->save($folder . '/' . $thumb);
        $photo->setThumb($thumb);

        $this->photoManager->save($photo);

        $response['success'] = true;

        return $response;
    }

    private function generateFileName(): string
    {
        return md5(uniqid('', true)) . '.jpg';
    }
}
