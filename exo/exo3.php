<?php

interface EntityInterface
{
    public function getId(): ?int;

    public function getCreatedAt(): ?DateTime;

    public function getUpdatedAt(): ?DateTime;
}

abstract class AbstractEntity
{
    /** @var int|null */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

}

trait TimestampableTrait
{
    /** @var DateTime|null */
    private $createdAt;
    /** @var DateTime|null */
    private $updatedAt;

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}

class News extends AbstractEntity implements EntityInterface
{
    use TimestampableTrait;

    public function __construct()
    {
    }
}
