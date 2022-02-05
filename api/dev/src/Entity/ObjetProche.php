<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * ObjetProche
 *
 * @ORM\Table(name="objet_proche")
 * @ORM\Entity
 */
class ObjetProche
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_objet_proche", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="objet_proche_id_objet_proche_seq", allocationSize=1, initialValue=1)
     */
    private $idObjetProche;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=32, nullable=true, options={"fixed"=true})
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="magnitude", type="decimal", precision=10, scale=5, nullable=true)
     */
    private $magnitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ra", type="decimal", precision=10, scale=5, nullable=true)
     */
    private $ra;

    /**
     * @var string|null
     *
     * @ORM\Column(name="deca", type="decimal", precision=10, scale=5, nullable=true)
     */
    private $deca;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=32, nullable=true, options={"fixed"=true})
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="date_approbation", type="string", length=32, nullable=true, options={"fixed"=true})
     */
    private $dateApprobation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Constellation", inversedBy="idObjetProche")
     * @ORM\JoinTable(name="determiner",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_objet_proche", referencedColumnName="id_objet_proche")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_constellation", referencedColumnName="id_constellation")
     *   }
     * )
     */
    private $idConstellation;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idConstellation = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdObjetProche(): ?int
    {
        return $this->idObjetProche;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMagnitude(): ?string
    {
        return $this->magnitude;
    }

    public function setMagnitude(?string $magnitude): self
    {
        $this->magnitude = $magnitude;

        return $this;
    }

    public function getRa(): ?string
    {
        return $this->ra;
    }

    public function setRa(?string $ra): self
    {
        $this->ra = $ra;

        return $this;
    }

    public function getDeca(): ?string
    {
        return $this->deca;
    }

    public function setDeca(?string $deca): self
    {
        $this->deca = $deca;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateApprobation(): ?string
    {
        return $this->dateApprobation;
    }

    public function setDateApprobation(?string $dateApprobation): self
    {
        $this->dateApprobation = $dateApprobation;

        return $this;
    }

    /**
     * @return Collection|Constellation[]
     */
    public function getIdConstellation(): Collection
    {
        return $this->idConstellation;
    }

    public function addIdConstellation(Constellation $idConstellation): self
    {
        if (!$this->idConstellation->contains($idConstellation)) {
            $this->idConstellation[] = $idConstellation;
        }

        return $this;
    }

    public function removeIdConstellation(Constellation $idConstellation): self
    {
        $this->idConstellation->removeElement($idConstellation);

        return $this;
    }

}
