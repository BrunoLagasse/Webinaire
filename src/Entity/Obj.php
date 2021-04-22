<?php

namespace App\Entity;

use App\Repository\ObjRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObjRepository::class)
 */
class Obj
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo_link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video_link;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $summarize;

    /**
     * @ORM\OneToMany(targetEntity=Demande::class, mappedBy="obj_requested", orphanRemoval=true)
     */
    private $demandes;

    /**
     * @ORM\ManyToMany(targetEntity=Statistic::class, mappedBy="objView")
     */
    private $statistics;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->nbView = new ArrayCollection();
        $this->statistics = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->id;
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

    public function getPhotoLink(): ?string
    {
        return $this->photo_link;
    }

    public function setPhotoLink(?string $photo_link): self
    {
        $this->photo_link = $photo_link;

        return $this;
    }

    public function getVideoLink(): ?string
    {
        return $this->video_link;
    }

    public function setVideoLink(?string $video_link): self
    {
        $this->video_link = $video_link;

        return $this;
    }

    public function getSummarize(): ?string
    {
        return $this->summarize;
    }

    public function setSummarize(?string $summarize): self
    {
        $this->summarize = $summarize;

        return $this;
    }

    /**
     * @return Collection|Demande[]
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setObjRequested($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getObjRequested() === $this) {
                $demande->setObjRequested(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Statistic[]
     */
    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    public function addStatistic(Statistic $statistic): self
    {
        if (!$this->statistics->contains($statistic)) {
            $this->statistics[] = $statistic;
            $statistic->addObjView($this);
        }

        return $this;
    }

    public function removeStatistic(Statistic $statistic): self
    {
        if ($this->statistics->removeElement($statistic)) {
            $statistic->removeObjView($this);
        }

        return $this;
    }
}
