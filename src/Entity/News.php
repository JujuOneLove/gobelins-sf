<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 * @Gedmo\SoftDeleteable(timeAware=true)
 */
class News
{
    use EntityTrait;
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @Assert\Length(
     *      min = 3,
     *      max = 10,
     *      minMessage = "Le titre est trop petit",
     *      maxMessage = "Le titre est trop grand"
     * )
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $title;

    /**
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le titre est trop petit"
     * )
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
