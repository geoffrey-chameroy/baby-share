<?php

namespace App\Controller\Admin;

use App\Form\PhotoType;
use App\Service\Manager\PhotoManager;
use App\Service\Manager\PhotoPublicationManager;
use App\Service\Manager\UserManager;
use App\Service\Provider\EmailProvider;
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
     * @Route("/page-{page<\d+>}", name="admin_photo_list")
     * @param int $page
     * @return Response
     */
    public function listPage(int $page): Response
    {
        $nbPage = $this->photoManager->getNbPage();

        return $this->render('admin/photo/photo-list.html.twig', [
            'unPublishedPhotos' => $this->photoManager->getUnPublished(),
            'photos' => $this->photoManager->getListPerPage($page),
            'page' => $page,
            'nbPage' => $nbPage,
        ]);
    }

    /**
     * @Route("/un-published", name="admin_photo_list_un_published")
     * @return Response
     */
    public function listUnPublished(): Response
    {
        return $this->render('admin/photo/photo-list-un-published.html.twig', [
            'unPublishedPhotos' => $this->photoManager->getUnPublished(),
        ]);
    }

    /**
     * @Route("/page-{page<\d+>}/{id<\d+>}/edit", name="admin_photo_edit")
     * @param Request $request
     * @param int $page
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, int $page, int $id): Response
    {
        $photo = $this->photoManager->get($id);
        $form = $this->createForm(PhotoType::class, $photo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->photoManager->save($photo);

            return $this->redirectToRoute('admin_photo_list', ['page' => $page]);
        }

        return $this->render(
            'admin/photo/edit.html.twig', [
            'form' => $form->createView(),
            'photo' => $photo,
        ]);
    }

    /**
     * @Route("/publish", name="admin_photo_publish")
     * @param Request $request
     * @param PhotoPublicationManager $publicationManager
     * @param UserManager $userManager
     * @param EmailProvider $emailProvider
     * @return Response
     */
    public function publish(
        Request $request,
        PhotoPublicationManager $publicationManager,
        UserManager $userManager,
        EmailProvider $emailProvider
    ): Response
    {
        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('admin-photo-publish', $token)) {
            $publication = $publicationManager->getNew();
            $this->photoManager->publish($publication);

            $users = $userManager->getList();
            $subject = 'Nouvelles photos';
            $content = $this->renderView('email/new-photos.html.twig');
            $emailProvider->sendEmail($users, $subject, $content);
        }

        return $this->redirectToRoute('admin_photo_list', ['page' => 1]);
    }

    /**
     * @Route("/remove", name="admin_photo_remove")
     * @param Request $request
     * @return Response
     */
    public function remove(Request $request): Response
    {
        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('admin-photo-remove', $token)) {
            $photo = $this->photoManager->get($request->request->get('id'));
            $this->photoManager->remove($photo);
        }

        $url = $request->request->get('redirect') ?
            $request->request->get('redirect') :
            $this->generateUrl('admin_photo_list', ['page' => 1]);

        return $this->redirect($url);
    }

    /**
     * @Route("/restore", name="admin_photo_restore")
     * @param Request $request
     * @return Response
     */
    public function restore(Request $request): Response
    {
        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('admin-photo-restore', $token)) {
            $photo = $this->photoManager->get($request->request->get('id'));
            $this->photoManager->restore($photo);
        }

        $url = $request->request->get('redirect') ?
            $request->request->get('redirect') :
            $this->generateUrl('admin_photo_list', ['page' => 1]);

        return $this->redirect($url);
    }
}
