<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DecisionRepository")
 */
class Decision
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
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $allowedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $changedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isTaken;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Document", inversedBy="decision", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $document;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contributor", inversedBy="decision",cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contributor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAllowedAt(): ?\DateTimeInterface
    {
        return $this->allowedAt;
    }

    public function setAllowedAt(\DateTimeInterface $allowedAt): self
    {
        $this->allowedAt = $allowedAt;

        return $this;
    }

    public function getChangedAt(): ?\DateTimeInterface
    {
        return $this->changedAt;
    }

    public function setChangedAt(\DateTimeInterface $changedAt): self
    {
        $this->changedAt = $changedAt;

        return $this;
    }

    public function getIsTaken(): ?bool
    {
        return $this->isTaken;
    }

    public function setIsTaken(?bool $isTaken): self
    {
        $this->isTaken = $isTaken;

        return $this;
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setDocument(?Document $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function getContributor(): ?Contributor
    {
        return $this->contributor;
    }

    public function setStructure(Contributor $contributor): self
    {
        $this->contributor = $contributor;

        return $this;
    }
}
