<?php

namespace App\Entity;

use App\Repository\StatisticRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatisticRepository::class)
 */
class Statistic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", type="integer",nullable=true, options={"default" : 1})
     */
    private $vue;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity=Obj::class, inversedBy="statistics")
     */
    private $objView;

    public function __construct()
    {
        $this->obj_requested = new ArrayCollection();
        $this->objView = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVue(): ?int
    {
        return $this->vue;
    }

    public function setVue(?int $vue): self
    {
        $this->vue = $vue;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Obj[]
     */
    public function getObjView(): Collection
    {
        return $this->objView;
    }

    public function addObjView(Obj $objView): self
    {
        if (!$this->objView->contains($objView)) {
            $this->objView[] = $objView;
        }

        return $this;
    }

    public function removeObjView(Obj $objView): self
    {
        $this->objView->removeElement($objView);

        return $this;
    }
}
