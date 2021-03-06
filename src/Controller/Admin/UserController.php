<?php

namespace App\Controller\Admin;

use App\Service\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users")
 */
class UserController extends Controller
{
    /** @var UserManager */
    private $userManager;
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Route("/", name="admin_user_list")
     * @return Response
     */
    public function list(): Response
    {
        return $this->render('admin/user/user-list.html.twig', [
            'users' => $this->userManager->getList(),
        ]);
    }

    /**
     * @Route("/enable", name="admin_user_enable")
     * @param Request $request
     * @return Response
     */
    public function enable(Request $request): Response
    {
        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('admin-user-enable', $token)) {
            $user = $this->userManager->get($request->request->get('id'));
            $user->setEnabled(true);
            $this->userManager->save($user);
        }

        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * @Route("/disable", name="admin_user_disable")
     * @param Request $request
     * @return Response
     */
    public function disable(Request $request): Response
    {
        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('admin-user-disable', $token)) {
            $user = $this->userManager->get($request->request->get('id'));
            $user->setEnabled(false);
            $this->userManager->save($user);
        }

        return $this->redirectToRoute('admin_user_list');
    }
}
