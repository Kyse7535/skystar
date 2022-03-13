<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jeu
 *
 * @ORM\Table(name="jeu", indexes={@ORM\Index(name="i_fk_jeu_objet_distant", columns={"id_objet_distant"}), @ORM\Index(name="i_fk_jeu_constellation", columns={"id_constellation"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Jeu
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_jeu", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="jeu_id_jeu_seq", allocationSize=1, initialValue=1)
     */
    private $idJeu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pseudo", type="string", length=20, nullable=true, options={"fixed"=true})
     */
    private $pseudo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="trouver", type="smallint", nullable=true)
     */
    private $trouver;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="duree", type="datetime", nullable=true)
     */
    private $duree;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     */
    private $dateCreation;

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
     * @var \Constellation
     *
     * @ORM\ManyToOne(targetEntity="Constellation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_constellation", referencedColumnName="id_constellation")
     * })
     */
    private $idConstellation;

    /**
     * @var \ObjetDistant
     *
     * @ORM\ManyToOne(targetEntity="ObjetDistant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_objet_distant", referencedColumnName="id_objet_distant")
     * })
     */
    private $idObjetDistant;

    public function getIdJeu(): ?int
    {
        return $this->idJeu;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getTrouver(): ?int
    {
        return $this->trouver;
    }

    public function setTrouver(?int $trouver): self
    {
        $this->trouver = $trouver;

        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(?\DateTimeInterface $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreated(): self
    {
        $this->created = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdated(): self
    {
        $this->updated = new \DateTimeImmutable();

        return $this;
    }

    public function getIdConstellation(): ?Constellation
    {
        return $this->idConstellation;
    }

    public function setIdConstellation(?Constellation $idConstellation): self
    {
        $this->idConstellation = $idConstellation;

        return $this;
    }

    public function getIdObjetDistant(): ?ObjetDistant
    {
        return $this->idObjetDistant;
    }

    public function setIdObjetDistant(?ObjetDistant $idObjetDistant): self
    {
        $this->idObjetDistant = $idObjetDistant;

        return $this;
    }


}
