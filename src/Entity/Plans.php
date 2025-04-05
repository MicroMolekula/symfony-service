<?php

namespace App\Entity;

use App\Repository\PlansRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: PlansRepository::class)]
class Plans
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['plan:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['plan:read'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    #[Groups(['plan:read'])]
    private ?string $dishes = null;

    #[ORM\Column(length: 255)]
    #[Groups(['plan:read'])]
    private ?string $exercises = null;

    #[ORM\ManyToOne(inversedBy: 'plans')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDishes(): ?string
    {
        return $this->dishes;
    }

    public function setDishes(string $dishes): static
    {
        $this->dishes = $dishes;

        return $this;
    }

    public function getExercises(): ?string
    {
        return $this->exercises;
    }

    public function setExercises(string $exercises): static
    {
        $this->exercises = $exercises;

        return $this;
    }

    public function getUserId(): ?Users
    {
        return $this->user;
    }

    public function setUserId(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }
}
