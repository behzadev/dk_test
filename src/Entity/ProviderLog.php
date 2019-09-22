<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProviderLogRepository")
 */
class ProviderLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $success_count;

    /**
     * @ORM\Column(type="integer")
     */
    private $failed_count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSuccessCount(): ?int
    {
        return $this->success_count;
    }

    public function setSuccessCount(int $success_count): self
    {
        $this->success_count = $success_count;

        return $this;
    }

    public function getFailedCount(): ?int
    {
        return $this->failed_count;
    }

    public function setFailedCount(int $failed_count): self
    {
        $this->failed_count = $failed_count;

        return $this;
    }
}
