<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Article;

use App\Domain\Entity\Article\Article;
use App\Domain\Entity\User\User;
use App\Domain\Repository\Article\ArticleRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\BaseDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;

class ArticleRepository extends BaseDoctrineRepository implements ArticleRepositoryInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Article::class);
    }

    /**
     * @inheritDoc
     */
    public function findArticles(): array
    {
        return $this->repository->findBy([], ['id' => "DESC"]);
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): Article
    {
        $user = $this->repository->find($id);
        if (!$user instanceof Article) {
            throw new DomainException('Article not found.');
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function save(Article $article): void
    {
        $this->em->persist($article);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function delete(Article $article): void
    {
        $this->em->remove($article);
        $this->em->flush();
    }
}
