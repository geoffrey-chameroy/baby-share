<?php

namespace App\Controller\Admin;

use App\Service\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /** @var UserManager */
    private $userManager;
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Route("/users", name="admin_user_list")
     * @return Response
     */
    public function list(): Response
    {
        return $this->render('admin/user/user-list.html.twig', [
            'users' => $this->userManager->getList(),
        ]);
    }

    /**
     * @Route("/users/enable", name="admin_user_enable")
     * @param Request $request
     * @return Response
     */
    public function enable(Request $request): Response
    {
        $user = $this->userManager->get($request->request->get('id'));

        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('admin-user-enable', $token)) {
            $user->setEnabled(true);
            $this->userManager->save($user);
        }

        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * @Route("/users/disable", name="admin_user_disable")
     * @param Request $request
     * @return Response
     */
    public function disable(Request $request): Response
    {
        $user = $this->userManager->get($request->request->get('id'));

        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('admin-user-disable', $token)) {
            $user->setEnabled(false);
            $this->userManager->save($user);
        }

        return $this->redirectToRoute('admin_user_list');
    }
}
