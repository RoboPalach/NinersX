<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Faker\Provider\DateTime;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BonusCodeRepository")
 */
class BonusCode
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
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $activeFrom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $activeTo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $item;

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getActiveFrom(): ?\DateTimeInterface
    {
        return $this->activeFrom;
    }

    public function setActiveFrom(?\DateTimeInterface $activeFrom): self
    {
        $this->activeFrom = $activeFrom;

        return $this;
    }

    public function getActiveTo(): ?\DateTimeInterface
    {
        return $this->activeTo;
    }

    public function setActiveTo(?\DateTimeInterface $activeTo): self
    {
        $this->activeTo = $activeTo;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getItem(): ?int
    {
        return $this->item;
    }

    public function setItem(int $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function isActive(){
        $now = new \DateTime("now");
        if($this->active){
            if($this->activeFrom<$now||empty($this->activeFrom)&&
                $this->activeTo>$now||empty($this->activeTo))
                return true;
        }
        return false;
    }

    public function getAward(User $user){
        switch ($this->type){
            case 1:
                $user->setKarma($user->getKarma()+$this->item);
                break;
            case 2:
                $user->changeMoney($this->item);
                break;
            case 3:
                //TODO: Implement shopItem giving
                throw new Exception("This feature isnt implemented yet");
        }
    }
}
