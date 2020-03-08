<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="integer")
     */
    private $karma;

    /**
     * @ORM\Column(type="integer")
     */
    private $money;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name","surname","id"})
     */

    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bio;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Team", mappedBy="members")
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="owner")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Course", mappedBy="owner")
     */
    private $courses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chapter", mappedBy="owner")
     */
    private $chapters;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ShopItem", mappedBy="author")
     */
    private $shopItems;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ShopItem", mappedBy="owners")
     */
    private $boughtItems;


    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->chapters = new ArrayCollection();
        $this->shopItems = new ArrayCollection();
        $this->boughtItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getKarma(): ?int
    {
        return $this->karma;
    }

    public function setKarma(int $karma): self
    {
        $this->karma = $karma;

        return $this;
    }

    public function changeKarma(int $change): self
    {
        if($change>0)
            $this->changeMoney($change);
        $this->karma+=$change;
        return $this;
    }

    public function getMoney(): ?int
    {
        return $this->money;
    }

    public function setMoney(int $money): self
    {
        $this->money = $money;

        return $this;
    }

    public  function changeMoney(int $change):self
    {
        $this->money +=$change;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getAvatar(){
        return "https://robohash.org/".$this->slug;
    }

    public function __toString()
    {
        return $this->name." ".$this->surname;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->addMember($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            $team->removeMember($this);
        }

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
            $image->setOwner($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getOwner() === $this) {
                $image->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setOwner($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->contains($course)) {
            $this->courses->removeElement($course);
            // set the owning side to null (unless already changed)
            if ($course->getOwner() === $this) {
                $course->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Chapter[]
     */
    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapter $chapter): self
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters[] = $chapter;
            $chapter->setOwner($this);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter): self
    {
        if ($this->chapters->contains($chapter)) {
            $this->chapters->removeElement($chapter);
            // set the owning side to null (unless already changed)
            if ($chapter->getOwner() === $this) {
                $chapter->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ShopItem[]
     */
    public function getShopItems(): Collection
    {
        return $this->shopItems;
    }

    public function addShopItem(ShopItem $shopItem): self
    {
        if (!$this->shopItems->contains($shopItem)) {
            $this->shopItems[] = $shopItem;
            $shopItem->setAuthor($this);
        }

        return $this;
    }

    public function removeShopItem(ShopItem $shopItem): self
    {
        if ($this->shopItems->contains($shopItem)) {
            $this->shopItems->removeElement($shopItem);
            // set the owning side to null (unless already changed)
            if ($shopItem->getAuthor() === $this) {
                $shopItem->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ShopItem[]
     */
    public function getBoughtItems(): Collection
    {
        return $this->boughtItems;
    }

    public function addBoughtItem(ShopItem $boughtItem): self
    {
        if (!$this->boughtItems->contains($boughtItem)) {
            $this->boughtItems[] = $boughtItem;
            $boughtItem->addOwner($this);
        }

        return $this;
    }

    public function removeBoughtItem(ShopItem $boughtItem): self
    {
        if ($this->boughtItems->contains($boughtItem)) {
            $this->boughtItems->removeElement($boughtItem);
            $boughtItem->removeOwner($this);
        }

        return $this;
    }

}
