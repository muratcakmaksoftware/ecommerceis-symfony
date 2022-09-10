<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Component\Serializer\SerializerInterface;

class BaseService
{
    protected EntityManagerInterface $em;
    protected SerializerInterface $serializer;
    protected $repository;

    /**
     * @param $attributes
     * @param bool $flush
     * @return mixed
     */
    public function store($attributes, bool $flush = true)
    {
        $entityClass = $this->repository->getClassName();
        $entity = new $entityClass;
        foreach ($attributes as $key => $attribute) {
            $entity->{'set' . ucfirst($key)}($attribute);
        }
        $this->repository->add($entity, $flush);
        return $entity;
    }

    /**
     * @param $entity
     * @param array $attributes
     * @param bool $flush
     * @return mixed
     */
    public function update($entity, array $attributes = [], bool $flush = true)
    {
        if (count($attributes) > 0) {
            foreach ($attributes as $key => $attribute) {
                $entity->{'set' . ucfirst($key)}($attribute);
            }
        }
        $this->repository->update($entity, $flush);
        return $entity;
    }

    /**
     * @param $entity
     * @param bool $flush
     * @return void
     */
    public function remove($entity, bool $flush = true)
    {
        $this->repository->remove($entity, $flush);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param bool $notFoundException
     * @return mixed
     * @throws Exception
     */
    public function findOneBy(array $criteria, ?array $orderBy = null, bool $notFoundException = true)
    {
        $entity = $this->repository->findOneBy($criteria, $orderBy);
        if (is_null($entity) && $notFoundException) {
            throw (new EntityNotFoundException())::fromClassNameAndIdentifier($this->repository->getClassName(), $criteria);
        }
        return $entity;
    }
}