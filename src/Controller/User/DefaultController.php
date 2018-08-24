<?php

namespace App\Controller\User;

use App\Service\Manager\PhotoManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @param PhotoManager $photoManager
     * @return Response
     */
    public function home(PhotoManager $photoManager): Response
    {
        return $this->render('user/default/home.html.twig', [
            'photos' => $photoManager->getLastPublished()
        ]);
    }
}
