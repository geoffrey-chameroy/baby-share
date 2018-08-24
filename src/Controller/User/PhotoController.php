<?php

namespace App\Controller\User;

use App\Service\Manager\PhotoManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/photos")
 */
class PhotoController Extends Controller
{
    /**
     * @Route(
     *     "/{id}.jpg", name="photo_view",
     *     requirements={"id": "\d+"},
     *     methods={"GET"}
     * )
     * @param PhotoManager $photoManager
     * @param int $id
     * @return BinaryFileResponse
     */
    public function view(PhotoManager $photoManager, int $id): BinaryFileResponse
    {
        $photo = $photoManager->get($id);

        $directory = $this->get('kernel')->getRootDir() . '/../uploads';
        $file = $directory . '/' . $photo->getFileName();

        return new BinaryFileResponse($file);
    }

    /**
     * @Route(
     *     "/add", name="photo_add",
     *     methods={"GET"}
     * )
     * @return Response
     */
    public function add(): Response
    {
        return $this->render('user/photo/add.html.twig');
    }
}
