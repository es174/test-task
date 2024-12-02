<?php

declare(strict_types=1);

namespace App\Domain\Repository\Article;

use App\Domain\Entity\Article\Article;
use App\Domain\Entity\User\User;
use App\Domain\RepositoryFilter\User\UserFilter;
use DomainException;

interface ArticleRepositoryInterface
{
    /**
     * Найти все статьи
     *
     * @return Article[]
     */
    public function findArticles(): array;

    /**
     * Найти статью по ID
     *
     * @param int $id
     *
     * @return Article
     *
     * @throws DomainException
     */
    public function findById(int $id): Article;

    /**
     * Сохранить статью
     *
     * @param Article $article
     * @return void
     */
    public function save(Article $article): void;

    /**
     * Удалить статью
     *
     * @param Article $article
     * @return void
     */
    public function delete(Article $article): void;
}
