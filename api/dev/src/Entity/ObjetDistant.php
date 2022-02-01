<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * ObjetDistant
 *
 * @ORM\Table(name="objet_distant")
 * @ORM\Entity
 */
#[ApiResource(
    normalizationContext: [ 'groups' => ['read:collection', 'read:constellation']]
)]
class ObjetDistant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_objet_distant", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="objet_distant_id_objet_distant_seq", allocationSize=1, initialValue=1)
     */

    #[Groups(['read:collection'])]
    private $idObjetDistant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ra", type="decimal", precision=10, scale=5, nullable=true)
     */
    #[Groups(['read:collection'])]
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
     * @ORM\Column(name="magnitude", type="decimal", precision=10, scale=3, nullable=true)
     */
    private $magnitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ra_radians", type="decimal", precision=10, scale=5, nullable=true)
     */
    private $raRadians;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dec_radians", type="decimal", precision=10, scale=5, nullable=true)
     */
    private $decRadians;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=true, options={"fixed"=true})
     */
    private $type;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Constellation", inversedBy="idObjetDistant")
     * @ORM\JoinTable(name="grouper",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_objet_distant", referencedColumnName="id_objet_distant")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_constellation", referencedColumnName="id_constellation")
     *   }
     * )
     */
    #[Groups(['read:collection'])]
    private $idConstellation;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idConstellation = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdObjetDistant(): ?int
    {
        return $this->idObjetDistant;
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

    public function getRaRadians(): ?string
    {
        return $this->raRadians;
    }

    public function setRaRadians(?string $raRadians): self
    {
        $this->raRadians = $raRadians;

        return $this;
    }

    public function getDecRadians(): ?string
    {
        return $this->decRadians;
    }

    public function setDecRadians(?string $decRadians): self
    {
        $this->decRadians = $decRadians;

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
