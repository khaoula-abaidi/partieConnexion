<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 */
class Document
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
    private $doi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modfiedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Contributor", mappedBy="documents")
     */
    private $contributors;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Decision", mappedBy="document", cascade={"persist", "remove"})
     */
    private $decision;


    public function __construct()
    {
        $this->modfiedAt = new \DateTime();
        $this->createdAt = new \DateTime();
        $this->contributors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoi(): ?string
    {
        return $this->doi;
    }

    public function setDoi(string $doi): self
    {
        $this->doi = $doi;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModfiedAt(): ?\DateTimeInterface
    {
        return $this->modfiedAt;
    }

    public function setModfiedAt(\DateTimeInterface $modfiedAt): self
    {
        $this->modfiedAt = $modfiedAt;

        return $this;
    }

    /**
     * @return Collection|Contributor[]
     */
    public function getContributors(): Collection
    {
        return $this->contributors;
    }

    public function addContributor(Contributor $contributor): self
    {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors[] = $contributor;
            $contributor->addDocument($this);
        }

        return $this;
    }

    public function removeContributor(Contributor $contributor): self
    {
        if ($this->contributors->contains($contributor)) {
            $this->contributors->removeElement($contributor);
            $contributor->removeDocument($this);
        }

        return $this;
    }

    public function getDecision(): ?Decision
    {
        return $this->decision;
    }

    public function setDecision(?Decision $decision): self
    {
        $this->decision = $decision;

        // set (or unset) the owning side of the relation if necessary
        $newDocument = $decision === null ? null : $this;
        if ($newDocument !== $decision->getDocument()) {
            $decision->setDocument($newDocument);
        }

        return $this;
    }

}
