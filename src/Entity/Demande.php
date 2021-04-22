<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\DemandeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DemandeRepository::class)
 */
class Demande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Demandeur::class, inversedBy="demandes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $person_asking;

    /**
     * @ORM\ManyToOne(targetEntity=Obj::class, inversedBy="demandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $obj_requested;
    
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPersonAsking(): ?Demandeur
    {
        return $this->person_asking;
    }

    public function setPersonAsking(?Demandeur $person_asking): self
    {
        $this->person_asking = $person_asking;

        return $this;
    }

    public function getObjRequested(): ?Obj
    {
        return $this->obj_requested;
    }

    public function setObjRequested(?Obj $obj_requested): self
    {
        $this->obj_requested = $obj_requested;

        return $this;
    }
}
