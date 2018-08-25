<?php

namespace App\Service\Manager;

use App\Entity\User;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method PhotoRepository getRepository()
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
}
