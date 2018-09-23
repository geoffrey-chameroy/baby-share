<?php

namespace App\Controller\Open;

use App\Service\Manager\PhotoManager;
use App\Service\Manager\PhotoPublicationManager;
use App\Service\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends Controller
{
    /**
     * @Route("/email/unsubscribe/{email}", name="public_email_unsubscribe")
     * @param string $email
     * @param UserManager $userManager
     * @return Response
     */
    public function emailUnsubscribe(string $email, UserManager $userManager): Response
    {
        $user = $userManager->getByEmail($email);
        if ($user) {
            $user->setNewsletter(false);
            $userManager->save($user);
        }

        return $this->render('public/email/unsubscribe.html.twig', [
            'email' => $email
        ]);
    }
}
