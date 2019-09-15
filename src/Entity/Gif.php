<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GifRepository")
 */
class Gif
{

    use EntityTrait;
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     *
     * @Assert\Url
     * @ORM\Column(type="string")
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Album", inversedBy="gifs")
     */
    private $album;

    /**
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Minimum 3 carractères",
     * )
     * @ORM\Column(type="string")
     */
    private $tag;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favorites")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }
    public function __toString(): string
    {
        return $this->link;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFavorite($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeFavorite($this);
        }

        return $this;
    }
}
