<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use \App\Enum\EnumGender;
use \App\Enum\EnumLevelOfTraining;
use \App\Enum\EnumAllergy;
use \App\Enum\EnumInventory;
use \App\Enum\EnumTarget;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?int $yandex_id = null;

    #[ORM\Column(enumType: EnumGender::class)]
    private ?EnumGender $gender = null;

    #[ORM\Column(length: 255)]
    private ?string $physical_limitations = null;

    #[ORM\Column(enumType: EnumLevelOfTraining::class)]
    private ?EnumLevelOfTraining $level_of_training = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: EnumAllergy::class)]
    private ?array $allergy = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: EnumInventory::class)]
    private ?array $inventory = null;

    #[ORM\Column(enumType: EnumTarget::class)]
    private ?EnumTarget $target = null;

    /**
     * @var Collection<int, Plans>
     */
    #[ORM\OneToMany(targetEntity: Plans::class, mappedBy: 'user')]
    private Collection $plans;

    /**
     * @var Collection<int, Messages>
     */
    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'user')]
    private Collection $messages;

    public function __construct()
    {
        $this->plans = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getYandexId(): ?int
    {
        return $this->yandex_id;
    }

    public function setYandexId(int $yandex_id): static
    {
        $this->yandex_id = $yandex_id;

        return $this;
    }

    public function getGender(): ?EnumGender
    {
        return $this->gender;
    }

    public function setGender(EnumGender $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPhysicalLimitations(): ?string
    {
        return $this->physical_limitations;
    }

    public function setPhysicalLimitations(string $physical_limitations): static
    {
        $this->physical_limitations = $physical_limitations;

        return $this;
    }

    public function getLevelOfTraining(): ?EnumLevelOfTraining
    {
        return $this->level_of_training;
    }

    public function setLevelOfTraining(EnumLevelOfTraining $level_of_training): static
    {
        $this->level_of_training = $level_of_training;

        return $this;
    }

    /**
     * @return EnumAllergy[]|null
     */
    public function getAllergy(): ?array
    {
        return $this->allergy;
    }

    public function setAllergy(?array $allergy): static
    {
        $this->allergy = $allergy;

        return $this;
    }

    /**
     * @return EnumInventory[]|null
     */
    public function getInventory(): ?array
    {
        return $this->inventory;
    }

    public function setInventory(?array $inventory): static
    {
        $this->inventory = $inventory;

        return $this;
    }

    public function getTarget(): ?EnumTarget
    {
        return $this->target;
    }

    public function setTarget(EnumTarget $target): static
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return Collection<int, Plans>
     */
    public function getPlans(): Collection
    {
        return $this->plans;
    }

    public function addPlan(Plans $plan): static
    {
        if (!$this->plans->contains($plan)) {
            $this->plans->add($plan);
            $plan->setUserId($this);
        }

        return $this;
    }

    public function removePlan(Plans $plan): static
    {
        if ($this->plans->removeElement($plan)) {
            // set the owning side to null (unless already changed)
            if ($plan->getUserId() === $this) {
                $plan->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setUserId($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUserId() === $this) {
                $message->setUserId(null);
            }
        }

        return $this;
    }
}
