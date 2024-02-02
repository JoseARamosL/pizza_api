<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\PizzaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PizzaRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
class Pizza
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 48)]
    #[Assert\NotBlank(groups: ['create'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::JSON)]
    #[Assert\Count(max: 20, maxMessage: "El número máximo de ingredientes es 20")]
    private array $ingredients = [];

    #[ORM\Column(nullable: true)]
    private ?int $ovenTimeInSeconds = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[ApiProperty(readable: true, writable: false)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[ApiProperty(readable: true, writable: false)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: false)]
    #[Assert\NotBlank(message: "El campo special es obligatorio al crear", groups: ['insert'])]
    #[ApiProperty(
        readable: true,
        writable: true,
        writableLink: false
    )]
    private ?bool $special = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients): static
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getOvenTimeInSeconds(): ?int
    {
        return $this->ovenTimeInSeconds;
    }

    public function setOvenTimeInSeconds(?int $ovenTimeInSeconds): static
    {
        $this->ovenTimeInSeconds = $ovenTimeInSeconds;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isSpecial(): ?bool
    {
        return $this->special;
    }

    public function setSpecial(?bool $special): static
    {

        if ($this->special === null) {
            $this->special = $special;
        }

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->setUpdatedAt(new \DateTimeImmutable());
    }
}
