<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_home")
     * @return Response
     */
    public function home(): Response
    {
        return $this->render('admin/default/home.html.twig');
    }
}
