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
}
