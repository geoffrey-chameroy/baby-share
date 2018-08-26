<?php

namespace App\Controller\User;

use App\Service\Manager\PhotoManager;
use App\Service\Manager\PhotoPublicationManager;
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
        if (!$photo->getPublication()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }

        $directory = $this->get('kernel')->getRootDir() . '/../uploads';
        $file = $directory . '/' . $photo->getWeb();

        return new BinaryFileResponse($file);
    }

    /**
     * @Route(
     *     "/thumb/{id}.jpg", name="photo_view_thumb",
     *     requirements={"id": "\d+"},
     *     methods={"GET"}
     * )
     * @param PhotoManager $photoManager
     * @param int $id
     * @return BinaryFileResponse
     */
    public function viewThumb(PhotoManager $photoManager, int $id): BinaryFileResponse
    {
        $photo = $photoManager->get($id);
        if (!$photo->getPublication()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }

        $directory = $this->get('kernel')->getRootDir() . '/../uploads';
        $file = $directory . '/' . $photo->getThumb();

        return new BinaryFileResponse($file);
    }

    /**
     * @Route(
     *     "/", name="photo_list",
     *     methods={"GET"}
     * )
     * @param PhotoPublicationManager $publicationManager
     * @return BinaryFileResponse
     */
    public function list(PhotoPublicationManager $publicationManager): Response
    {
        return $this->render('user/photo/list.html.twig', [
            'publications' => $publicationManager->getList()
        ]);
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
