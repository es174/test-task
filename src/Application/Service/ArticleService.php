<?php

namespace App\Application\Service;

use App\Domain\Entity\Article\Article;
use App\Domain\Repository\Article\ArticleRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\Article\ArticleRepository;

class ArticleService
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /** @return Article[] */
    public function getListArticles(): array
    {
        $result = [];
        foreach ($this->articleRepository->findArticles() as $article) {
            $result[] = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'count_views' => $article->getCountViewsString()
            ];
        }
        return $result;
    }

    public function deleteArticle($id): void
    {
        $this->articleRepository->delete($this->articleRepository->findById($id));
    }

    public function createArticle(array $body = []): void
    {
        if ($body == [])
            $body = [
                'title' => "Заголовок",
                'description' => "Описание"
            ];

        //ну вот тот самый мок данных
        $article = new Article(
            $body['title'],
            Article::generateRandomCountViews(),
            new \DateTimeImmutable(),
            rand(0, 1),
            $body['description']
        );

        $this->articleRepository->save($article);
    }

    public function getShowArticle($id): array
    {
        $article = $this->articleRepository->findById($id);
        $article->increaseCountViews();
        $this->articleRepository->save($article);

        return [
            'title' => $article->getTitle(),
            'description' => $article->getDescription(),
            'count_views' => $article->getCountViewsString(),
            'created_at' => $article->getCreatedAt()->format("d.m.Y H:i"),
            'is_active' => $article->isActive() ? "Да" : "Нет",
        ];
    }
}
