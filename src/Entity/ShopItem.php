<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShopItemRepository")
 */
class ShopItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="shopItems")
     */
    private $previewImage;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Image", inversedBy="shopItems")
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="shopItems")
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="boughtItems")
     */
    private $owners;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Chapter", inversedBy="shopItems")
     */
    private $tutorial;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->owners = new ArrayCollection();
        $this->tutorial = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPreviewImage(): ?Image
    {
        return $this->previewImage;
    }

    public function setPreviewImage(?Image $previewImage): self
    {
        $this->previewImage = $previewImage;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getOwners(): Collection
    {
        return $this->owners;
    }

    public function addOwner(User $owner): self
    {
        if (!$this->owners->contains($owner)) {
            $this->owners[] = $owner;
        }

        return $this;
    }

    public function removeOwner(User $owner): self
    {
        if ($this->owners->contains($owner)) {
            $this->owners->removeElement($owner);
        }

        return $this;
    }

    /**
     * @return Collection|Chapter[]
     */
    public function getTutorial(): Collection
    {
        return $this->tutorial;
    }

    public function addTutorial(Chapter $tutorial): self
    {
        if (!$this->tutorial->contains($tutorial)) {
            $this->tutorial[] = $tutorial;
        }

        return $this;
    }

    public function removeTutorial(Chapter $tutorial): self
    {
        if ($this->tutorial->contains($tutorial)) {
            $this->tutorial->removeElement($tutorial);
        }

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
