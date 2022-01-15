<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parcours
 *
 * @ORM\Table(name="parcours", indexes={@ORM\Index(name="i_fk_parcours_jeu", columns={"id_jeu"})})
 * @ORM\Entity
 */
class Parcours
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_parcours", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="parcours_id_parcours_seq", allocationSize=1, initialValue=1)
     */
    private $idParcours;

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
     * @ORM\Column(name="magnitude", type="decimal", precision=10, scale=5, nullable=true)
     */
    private $magnitude;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var \Jeu
     *
     * @ORM\ManyToOne(targetEntity="Jeu")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_jeu", referencedColumnName="id_jeu")
     * })
     */
    private $idJeu;

    public function getIdParcours(): ?int
    {
        return $this->idParcours;
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

    public function getMagnitude(): ?string
    {
        return $this->magnitude;
    }

    public function setMagnitude(?string $magnitude): self
    {
        $this->magnitude = $magnitude;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getIdJeu(): ?Jeu
    {
        return $this->idJeu;
    }

    public function setIdJeu(?Jeu $idJeu): self
    {
        $this->idJeu = $idJeu;

        return $this;
    }


}
