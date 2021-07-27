<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="admin", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_admin;

    /**
     * @ORM\OneToOne(targetEntity=Conversation::class, inversedBy="id_admin", cascade={"persist", "remove"})
     */
    private $conversation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAdmin(): ?User
    {
        return $this->id_admin;
    }

    public function setIdAdmin(User $id_admin): self
    {
        $this->id_admin = $id_admin;

        return $this;
    }

    public function getConversation(): ?Conversation
    {
        return $this->conversation;
    }

    public function setConversation(Conversation $conversation): self
    {
        // set the owning side of the relation if necessary
        if ($conversation->getIdAdmin() !== $this) {
            $conversation->setIdAdmin($this);
        }

        $this->conversation = $conversation;

        return $this;
    }
}
