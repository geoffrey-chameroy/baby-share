<?php

namespace App\Service\Manager;

use App\Entity\User;
use App\Repository\PhotoRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method UserRepository getRepository()
 * @method User           getNew()
 * @method User|null      get(int $id, bool $check = true)
 * @method User[]         getList()
 * @method User           save(User $user)
 * @method void           remove(User $user)
 * @method void           checkEntity(?User $user)
 */
class UserManager extends AbstractEntityManager
{
    public function __construct(EntityManagerInterface $em)
    {
         parent::__construct($em, User::class);
    }

    /**
     * @return User[]
     */
    public function getListNewsletter()
    {
        return $this->getRepository()->findBy([
            'newsletter' => 1,
            'enabled' => 1
        ]);
    }

    /**
     * @return User[]
     */
    public function getListAdmin()
    {
        return $this->getRepository()->findBy([
            'admin' => 1,
            'enabled' => 1
        ]);
    }

    public function getByEmail(string $email): ?User
    {
        return $this->getRepository()->findOneBy([
            'email' => $email
        ]);
    }
}
