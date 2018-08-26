<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    /** @var ObjectManager */
    private $manager;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadAdmin();
        $this->loadUser();
    }

    private function loadAdmin()
    {
        $user = (new User())
            ->setEmail('admin@test.fr')
            ->setPlainPassword('admin')
            ->setFirstName('John')
            ->setLastName('Smith')
            ->setPhone('0123456789')
            ->setEnabled(true)
            ->setAdmin(true);

        $password = $this->encoder
            ->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password)
            ->eraseCredentials();

        $this->setReference('user-admin', $user);
        $this->manager->persist($user);
        $this->manager->flush();
    }

    private function loadUser()
    {
        $user = (new User())
            ->setEmail('user@test.fr')
            ->setPlainPassword('user')
            ->setFirstName('John')
            ->setLastName('Smith')
            ->setPhone('0123456789')
            ->setEnabled(true);

        $password = $this->encoder
            ->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password)
            ->eraseCredentials();

        $this->setReference('user', $user);
        $this->manager->persist($user);
        $this->manager->flush();
    }
}
