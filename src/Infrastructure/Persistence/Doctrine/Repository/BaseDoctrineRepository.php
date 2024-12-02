<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\User\User;
use App\Domain\Repository\User\UserRepositoryInterface;
use App\Domain\RepositoryFilter\User\UserFilter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;
use DomainException;

abstract class BaseDoctrineRepository
{
    protected ObjectRepository $repository;

    protected EntityManagerInterface $em;

    /**
     * @param  string $entityClass The class name of the entity this repository manages
     * @psalm-param class-string<T> $entityClass
     */
    public function __construct(EntityManagerInterface $em, string $entityClass)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($entityClass);
    }
}
