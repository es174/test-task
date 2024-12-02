<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\User;

use App\Domain\Entity\User\User;
use App\Domain\Repository\User\UserRepositoryInterface;
use App\Domain\RepositoryFilter\User\UserFilter;
use App\Infrastructure\Persistence\Doctrine\Repository\BaseDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;
use DomainException;

class UserRepository extends BaseDoctrineRepository implements UserRepositoryInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, User::class);
    }

    private function qbAll(UserFilter $filter): QueryBuilder
    {
        $ex = $this->em->getExpressionBuilder();
        $qb = $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u');

        if ($filter->state !== null) {
            $qb->andWhere($ex->eq('u.state', ':state'))
                ->setParameter('state', $filter->state);
        }

        return $qb;
    }

    /**
     * @inheritDoc
     */
    public function findUsers(UserFilter $filter): array
    {
        return $this
            ->qbAll($filter)
            ->getQuery()
            ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): User
    {
        $user = $this->repository->find($id);
        if (!$user instanceof User) {
            throw new DomainException('User not found.');
        }

        return $user;
    }
    /**
     * @inheritDoc
     */
    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function delete(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }
}
