<?php

namespace App\Entity;

use App\Repository\LibraryRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use function Symfony\Component\Translation\t;

#[ORM\Entity(repositoryClass: LibraryRepository::class)]
class Library
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'boolean', options:["default" => false])]
    private bool $installed;

    #[ORM\Column(type: 'integer', options:["default" => 0])]
    private int $gameTime;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private DateTime $lastUsed;

    #[ORM\ManyToOne(targetEntity: Game::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Game $game;

    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'libraries')]
    #[ORM\JoinColumn(nullable: false)]
    private Account $account;

    public function __construct()
    {
        $this->gameTime = 0.0;
        $this->installed = 0.0;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstalled(): ?bool
    {
        return $this->installed;
    }

    public function setInstalled(bool $installed): self
    {
        $this->installed = $installed;

        return $this;
    }

    public function getGameTime(): ?int
    {
        return $this->gameTime;
    }

    public function setGameTime(int $gameTime): self
    {
        $this->gameTime = $gameTime;

        return $this;
    }

    public function getLastUsed(): ?DateTime
    {
        return $this->lastUsed;
    }

    public function setLastUsed(?DateTime $lastUsed): self
    {
        $this->lastUsed = $lastUsed;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }
}
