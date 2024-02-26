<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private Room $room;

    #[ORM\Column(length: 255)]
    private string $frequency;

    #[ORM\Column]
    private int $difficulty;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastDone = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?User $lastDoneBy = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRoom(): Room
    {
        return $this->room;
    }

    public function setRoom(Room $room): static
    {
        $this->room = $room;

        return $this;
    }

    public function getFrequency(): string
    {
        return $this->frequency;
    }

    public function setFrequency(string $frequency): static
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getDifficulty(): int
    {
        return $this->difficulty;
    }

    public function setDifficulty(int $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getLastDone(): ?\DateTimeInterface
    {
        return $this->lastDone;
    }

    public function setLastDone(?\DateTimeInterface $lastDone): static
    {
        $this->lastDone = $lastDone;

        return $this;
    }

    public function getLastDoneBy(): ?User
    {
        return $this->lastDoneBy;
    }

    public function setLastDoneBy(?User $lastDoneBy): static
    {
        $this->lastDoneBy = $lastDoneBy;

        return $this;
    }
}
