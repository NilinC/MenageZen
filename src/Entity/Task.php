<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use DateInterval;
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

    #[ORM\Column]
    private int $duration;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private Frequency $frequency;

    #[ORM\Column]
    private int $difficulty;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastDone = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private \DateTimeInterface $nextDone;

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

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getFrequency(): Frequency
    {
        return $this->frequency;
    }

    public function setFrequency(Frequency $frequency): static
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

    public function getNextDone(): \DateTimeInterface
    {
        return $this->nextDone;
    }

    public function setNextDone(?\DateTimeInterface $nextDone): static
    {
        $this->nextDone = $nextDone;

        return $this;
    }

    public function calculateNextDone(): void
    {
        $interval = DateInterval::createFromDateString($this->getDuration() . ' ' . $this->getFrequency()->getName());
        $date = new \DateTimeImmutable($this->getLastDone()->format('Y-m-d'));
        $this->setNextDone($date->add($interval));
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
