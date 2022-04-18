<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\MappedSuperclass]
abstract class BaseEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['commons'])]
    private UuidInterface|string $id;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['commons'])]
    private \DateTimeImmutable $createdAt;


    public function getId(): string
    {
        return (string)$this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function __construct()
    {
        $this->id = Uuid::uuid6();
        $this->createdAt = new \DateTimeImmutable();
    }


}