<?php

namespace App\Controller\User;

use App\Service\Manager\PhotoManager;
use App\Service\Manager\PhotoPublicationManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publications")
 */
class PhotoPublicationController Extends Controller
{
    public function view(PhotoPublicationManager $publicationManager, PhotoManager $photoManager, int $id): Response
    {
        $publication = $publicationManager->get($id);

        return $this->render('user/photo/_publication.html.twig', [
            'publication' => $publication,
            'photos' => $photoManager->getByPublication($publication)
        ]);
    }
}
