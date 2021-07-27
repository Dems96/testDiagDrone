<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 */
class Conversation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, inversedBy="conversation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Admin::class, inversedBy="conversation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_admin;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="id_conversation")
     */
    private $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtilisateur(): ?utilisateur
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(utilisateur $id_utilisateur): self
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getIdAdmin(): ?admin
    {
        return $this->id_admin;
    }

    public function setIdAdmin(admin $id_admin): self
    {
        $this->id_admin = $id_admin;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setIdConversation($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getIdConversation() === $this) {
                $message->setIdConversation(null);
            }
        }

        return $this;
    }
}
