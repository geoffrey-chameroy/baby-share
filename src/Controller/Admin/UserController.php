<?php

namespace App\Controller\Admin;

use App\Service\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("/users", name="admin_user")
     * @param UserManager $userManager
     * @return Response
     */
    public function users(UserManager $userManager): Response
    {
        return $this->render('admin/user/user-list.html.twig', [
            'users' => $userManager->getList(),
        ]);
    }
}
