<?php

namespace App\Entity;

use App\Controller\FilterById;
use App\Repository\ConstellationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;

use ApiPlatform\Core\Annotation\ApiProperty;
use App\Filter\ConstellationFilter;

/**
 * Constellation
 *
 * @ORM\Table(name="constellation")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ConstellationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
#[ApiResource(
    normalizationContext: [ 'groups' => ['read:infos']],
    itemOperations: ['get'],
    collectionOperations: [
        'get'
        ],
    paginationEnabled: false,
)]
#[ApiFilter(ConstellationFilter::class)]
class Constellation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_constellation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="constellation_id_constellation_seq", allocationSize=1, initialValue=1)
     */
    #[Groups(['read:constellation', 'read:infos'])]
    #[ApiProperty(identifier: true)]
    private $idConstellation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latin_name", type="string", length=50, nullable=true, options={"fixed"=true})
     */
    #[Groups(['read:constellation', 'read:infos'])]
    private $latinName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observation_saison", type="string", length=100, nullable=true, options={"fixed"=true})
     */
    #[Groups(['read:infos'])]
    private $observationSaison;

    /**
     * @var string|null
     *
     * @ORM\Column(name="etoile_principale", type="string", length=40, nullable=true, options={"fixed"=true})
     */
    #[Groups(['read:infos'])]
    private $etoilePrincipale;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ra", type="decimal", precision=10, scale=5, nullable=true)
     */
    #[Groups(['read:infos'])]
    private $ra;

    /**
     * @var string|null
     *
     * @ORM\Column(name="deca", type="decimal", precision=10, scale=5, nullable=true)
     */
    #[Groups(['read:infos'])]
    private $deca;

    /**
     * @var string|null
     *
     * @ORM\Column(name="taille", type="decimal", precision=15, scale=5, nullable=true)
     */
    #[Groups(['read:infos'])]
    private $taille;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created", type="datetime_immutable", nullable=true)
     */
    #[Groups(['read:infos'])]
    private $created;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated", type="datetime_immutable", nullable=true)
     */
    #[Groups(['read:infos'])]
    private $updated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ObjetDistant", mappedBy="idConstellation")
     */
    private $idObjetDistant;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ObjetProche", mappedBy="idConstellation")
     */
    private $idObjetProche;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idObjetDistant = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idObjetProche = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdConstellation(): ?int
    {
        return $this->idConstellation;
    }

    public function getLatinName(): ?string
    {
        return $this->latinName;
    }

    public function setLatinName(?string $latinName): self
    {
        $this->latinName = $latinName;

        return $this;
    }

    public function getObservationSaison(): ?string
    {
        return $this->observationSaison;
    }

    public function setObservationSaison(?string $observationSaison): self
    {
        $this->observationSaison = $observationSaison;

        return $this;
    }

    public function getEtoilePrincipale(): ?string
    {
        return $this->etoilePrincipale;
    }

    public function setEtoilePrincipale(?string $etoilePrincipale): self
    {
        $this->etoilePrincipale = $etoilePrincipale;

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

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(?string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getCreated(): ?\DateTimeImmutable
    {
        return $this->created;
    }

    #[ORM\PreUpdate, ORM\PrePersist]
    public function setCreated(): self
    {
        $this->created = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdated(): ?\DateTimeImmutable
    {
        return $this->updated;
    }


    /*public function updateTimestamps(){
        if($this->getCreated()===null){
            $this->created = new \DateTimeImmutable();
        }
        $this->updated = new \DateTimeImmutable();

        return $this;
    }
    */

    #[ORM\PreUpdate, ORM\PrePersist]
    public function setUpdated(): self
    {
        $this->updated = new \DateTimeImmutable();

        return $this;
    }

    /**
     * @return Collection|ObjetDistant[]
     */
    public function getIdObjetDistant(): Collection
    {
        return $this->idObjetDistant;
    }

    public function addIdObjetDistant(ObjetDistant $idObjetDistant): self
    {
        if (!$this->idObjetDistant->contains($idObjetDistant)) {
            $this->idObjetDistant[] = $idObjetDistant;
            $idObjetDistant->addIdConstellation($this);
        }

        return $this;
    }

    public function removeIdObjetDistant(ObjetDistant $idObjetDistant): self
    {
        if ($this->idObjetDistant->removeElement($idObjetDistant)) {
            $idObjetDistant->removeIdConstellation($this);
        }

        return $this;
    }

    /**
     * @return Collection|ObjetProche[]
     */
    public function getIdObjetProche(): Collection
    {
        return $this->idObjetProche;
    }

    public function addIdObjetProche(ObjetProche $idObjetProche): self
    {
        if (!$this->idObjetProche->contains($idObjetProche)) {
            $this->idObjetProche[] = $idObjetProche;
            $idObjetProche->addIdConstellation($this);
        }

        return $this;
    }

    public function removeIdObjetProche(ObjetProche $idObjetProche): self
    {
        if ($this->idObjetProche->removeElement($idObjetProche)) {
            $idObjetProche->removeIdConstellation($this);
        }

        return $this;
    }

}
