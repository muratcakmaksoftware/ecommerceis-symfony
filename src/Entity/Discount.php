<?php

namespace App\Entity;

use App\Repository\DiscountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DiscountRepository::class)
 * @ORM\Table(name="discounts")
 */
class Discount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @Groups({"discount"})
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"discount"})
     */
    private int $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"discount"})
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=2500, nullable=true)
     * @Groups({"discount"})
     */
    private ?string $description;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"discount"})
     */
    private bool $status;

    /**
     * @ORM\Column(type="text")
     * @Groups({"discount"})
     */
    private string $jsonData;

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param bool $jsonDecode
     * @return array|string
     */
    public function getJsonData(bool $jsonDecode = true)
    {
        return $jsonDecode ? json_decode($this->jsonData, true) : $this->jsonData;
    }

    /**
     * @param string $jsonData
     * @return $this
     */
    public function setJsonData(string $jsonData): self
    {
        $this->jsonData = $jsonData;

        return $this;
    }
}
