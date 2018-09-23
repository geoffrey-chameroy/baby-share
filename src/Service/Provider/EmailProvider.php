<?php

namespace App\Service\Provider;

use App\Entity\User;

class EmailProvider
{
    const FROM_EMAIL = 'no-reply@zen-unicorn.fr';
    const FROM_NAME = 'Zen Unicorn';

    /** @var \Swift_Mailer */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param User $user
     * @param string $subject
     * @param string $content
     */
    public function sendEmail(User $user, string $subject, string $content)
    {
        if (!$user->isNewsletter() || !$user->isEnabled()) {
            return;
        }

        $message = (new \Swift_Message($subject))
            ->setFrom(self::FROM_EMAIL, self::FROM_NAME)
            ->setTo($user->getEmail())
            ->setBody($content, 'text/html')
        ;
        $this->mailer->send($message);
    }
}
