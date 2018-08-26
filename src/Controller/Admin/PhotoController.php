<?php

namespace App\Controller\Admin;

use App\Service\Manager\PhotoManager;
use App\Service\Manager\PhotoPublicationManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/photos")
 */
class PhotoController extends Controller
{
    /** @var PhotoManager */
    private $photoManager;

    public function __construct(PhotoManager $photoManager)
    {
        $this->photoManager = $photoManager;
    }

    /**
     * @Route("/", name="admin_photo_list")
     * @return Response
     */
    public function list(): Response
    {
        return $this->render('admin/photo/photo-list.html.twig', [
            'photos' => $this->photoManager->getNonPublished(),
        ]);
    }

    /**
     * @Route("/publish", name="admin_photo_publish")
     * @param Request $request
     * @param PhotoPublicationManager $publicationManager
     * @return Response
     */
    public function publish(Request $request, PhotoPublicationManager $publicationManager): Response
    {
        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('admin-photo-publish', $token)) {
            $publication = $publicationManager->getNew();
            $this->photoManager->publish($publication);
        }

        return $this->redirectToRoute('admin_photo_list');
    }
}
