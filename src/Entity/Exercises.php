<?php

namespace App\Entity;

use App\Enum\EnumInventory;
use App\Enum\EnumTarget;
use App\Repository\ExercisesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExercisesRepository::class)]
class Exercises
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: EnumTarget::class)]
    private array $type = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: EnumInventory::class)]
    private array $inventory = [];

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

    /**
     * @return EnumTarget[]
     */
    public function getType(): array
    {
        return $this->type;
    }

    public function setType(array $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return EnumInventory[]
     */
    public function getInventory(): array
    {
        return $this->inventory;
    }

    public function setInventory(array $inventory): static
    {
        $this->inventory = $inventory;

        return $this;
    }
}
