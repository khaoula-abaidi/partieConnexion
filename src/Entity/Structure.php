<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StructureRepository")
 */
class Structure
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
    private $sigle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Structure", inversedBy="subStructures")
     */
    private $affiliation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Structure", mappedBy="affiliation")
     */
    private $subStructures;

    public function __construct()
    {
        $this->subStructures = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSigle(): ?string
    {
        return $this->sigle;
    }

    public function setSigle(string $sigle): self
    {
        $this->sigle = $sigle;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getSubStructures(): ?self
    {
        return $this->subStructures;
    }

    public function setSubStructures(?self $subStructures): self
    {
        $this->subStructures = $subStructures;

        return $this;
    }

    public function getAffiliation(): ?self
    {
        return $this->affiliation;
    }

    public function setAffiliation(?self $affiliation): self
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    public function addSubStructure(self $subStructure): self
    {
        if (!$this->subStructures->contains($subStructure)) {
            $this->subStructures[] = $subStructure;
            $subStructure->setAffiliation($this);
        }

        return $this;
    }

    public function removeSubStructure(self $subStructure): self
    {
        if ($this->subStructures->contains($subStructure)) {
            $this->subStructures->removeElement($subStructure);
            // set the owning side to null (unless already changed)
            if ($subStructure->getAffiliation() === $this) {
                $subStructure->setAffiliation(null);
            }
        }

        return $this;
    }

}
