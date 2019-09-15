<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album
{

    use EntityTrait;
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="albums")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gif", mappedBy="album")
     */
    private $gifs;

    public function __construct()
    {
        $this->gifs = new ArrayCollection();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?user
    {
        return $this->author;
    }

    public function setAuthor(?user $author): self
    {
        $this->author = $author;

        return $this;
    }
    public function __toString(): string
    {
        return $this->title;
    }

    /**
     * @return Collection|Gif[]
     */
    public function getGifs(): Collection
    {
        return $this->gifs;
    }

    public function addGif(Gif $gif): self
    {
        if (!$this->gifs->contains($gif)) {
            $this->gifs[] = $gif;
            $gif->setAlbum($this);
        }

        return $this;
    }

    public function removeGif(Gif $gif): self
    {
        if ($this->gifs->contains($gif)) {
            $this->gifs->removeElement($gif);
            // set the owning side to null (unless already changed)
            if ($gif->getAlbum() === $this) {
                $gif->setAlbum(null);
            }
        }

        return $this;
    }
}
