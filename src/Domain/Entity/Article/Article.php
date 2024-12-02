<?php

declare(strict_types=1);

namespace App\Domain\Entity\Article;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'article')]
class Article
{
    #[ORM\Id, ORM\Column(type: 'integer', options: ['unsigned' => true]), ORM\GeneratedValue]
    private ?int $id;

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'integer')]
    private int $countViews;

    #[ORM\Column(type: 'boolean', options: ['default' => 1])]
    private bool $isActive = true;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt;

    public function __construct(
        ?string            $title,
        int                $countViews,
        ?DateTimeImmutable $createdAt,
        bool               $isActive = true,
        ?string            $description = "",
    )
    {
        $this->id = null;
        $this->createdAt = $createdAt;

        $this->edit(
            $title,
            $countViews,
            $isActive,
            $description
        );
    }

    public function edit(?string $title,
                         int     $countViews,
                         bool    $isActive = true,
                         ?string $description = ""
    ): self
    {
        $this->title = $title;
        $this->countViews = $countViews;
        $this->isActive = $isActive;
        $this->description = $description;
        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getCountViews(): int
    {
        return $this->countViews;
    }

    //словарь для количества и его сокращения
    private const COUNT_TO_WORD_ARRAY = [
        1 => "",
        1000 => "K",
        1000000 => "М",
//        1000000000 => "G"
    ];

    public static function generateRandomCountViews(): int
    {
        //просто красивая генерация в отличие от  rand(1, 1000000) где в основном будет "K"
        return rand(1, 99) * (array_rand(Article::COUNT_TO_WORD_ARRAY));
    }

    public function getCountViewsString(): string
    {
        $countViews = $this->getCountViews();
        $lastKey = array_key_first(self::COUNT_TO_WORD_ARRAY);
        foreach (array_keys(self::COUNT_TO_WORD_ARRAY) as $key) {
            if ($countViews < $key)
                break;
            $lastKey = $key;
        }

        return intdiv($countViews, $lastKey) . self::COUNT_TO_WORD_ARRAY[$lastKey];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function increaseCountViews(int $count = 1): self
    {
        $this->countViews += $count;
        return $this;
    }
}
