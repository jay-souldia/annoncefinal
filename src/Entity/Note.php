<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avis;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_enregistrement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="note")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usernote;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="notant")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usernotant;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function setAvis(string $avis): self
    {
        $this->avis = $avis;

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeInterface
    {
        return $this->date_enregistrement;
    }

    public function setDateEnregistrement(\DateTimeInterface $date_enregistrement): self
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
    }

    public function getUsernote(): ?User
    {
        return $this->usernote;
    }

    public function setUsernote(?User $usernote): self
    {
        $this->usernote = $usernote;

        return $this;
    }

    public function getUsernotant(): ?User
    {
        return $this->usernotant;
    }

    public function setUsernotant(?User $usernotant): self
    {
        $this->usernotant = $usernotant;

        return $this;
    }

    
}
