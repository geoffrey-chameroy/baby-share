<?php

namespace App\Service\Manager;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntityManager
{
    /** @var EntityManagerInterface */
    private $_em;

    /** @var string */
    private $_entityName;

    /** @var ObjectRepository */
    private $_repository;

    public function __construct(EntityManagerInterface $em, string $entityName)
    {
        $this->_em = $em;
        $this->_entityName = $entityName;
        $this->_repository = $em->getRepository($entityName);
    }

    public function getManager(): EntityManagerInterface
    {
        return $this->_em;
    }

    public function getRepository(): ObjectRepository
    {
        return $this->_repository;
    }

    public function getNew()
    {
        return new $this->_entityName();
    }

    public function get(int $id, bool $check = true)
    {
        $entity = $this->_repository->find($id);
        if ($check) {
            $this->checkEntity($entity);
        }

        return $entity;
    }

    public function getList(): array
    {
        return $this->_repository->findAll();
    }

    public function save($entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }

    public function remove($entity)
    {
        if (!$entity) {
            return;
        }

        $this->_em->remove($entity);
        $this->_em->flush();
    }

    protected function checkEntity($entity)
    {
        if (!$entity) {
            throw new NotFoundHttpException();
        }
    }
}
