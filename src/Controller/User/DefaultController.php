<?php

namespace App\Controller\User;

use App\Service\Manager\PhotoManager;
use App\Service\Manager\PhotoPublicationManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @param PhotoPublicationManager $publicationManager
     * @param PhotoManager $photoManager
     * @return Response
     */
    public function home(PhotoPublicationManager $publicationManager, PhotoManager $photoManager): Response
    {
        $publication = $publicationManager->getLast();
        return $this->render('user/default/home.html.twig', [
            'photos' => $photoManager->getByPublication($publication)
        ]);
    }
}
