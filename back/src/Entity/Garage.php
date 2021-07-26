<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GarageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Annotation\ApiFilter;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_ADMIN')"
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_PRO')"
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_ADMIN') or object.professionnel == user"
 *          },
 *          "put"={
 *              "security"="is_granted('ROLE_ADMIN') or object.professionnel == user"
 *          },
 *          "delete"={
 *              "security"="is_granted('ROLE_ADMIN') or object.professionnel == user"
 *          },
 *          "patch"={
 *              "security"="is_granted('ROLE_ADMIN') or object.professionnel == user"
 *          }
 *      },
 *      normalizationContext={
 *          "groups"={"garage:get"}
 *      }
 * )
 * @ApiFilter(SearchFilter::class, properties={"nom"="partial","numTel"="partial","ville"="partial","codePostal"="partial",
 * "annonces.referenceAnnonce"="partial","professionnel.nom"="partial","professionnel.prenom"="partial",
 * "professionnel.numeroSiret"="partial"})
 * @ApiFilter(DateFilter::class, properties={"annonces.datePublication"})
 * @ORM\Entity(repositoryClass=GarageRepository::class)
 */
class Garage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"annonce:get", "garage:get","pro:get"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=12)
     * @Groups({"annonce:get", "garage:get","pro:get"})
     */
    private $numTel;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"annonce:get", "garage:get","pro:get"})
     */
    private $adresseLigne1;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"annonce:get", "garage:get", "pro:get"})
     */
    private $adresseLigne2;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"annonce:get", "garage:get", "pro:get"})
     */
    private $adresseLigne3;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"annonce:get", "garage:get", "pro:get"})
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"annonce:get", "garage:get", "pro:get"})
     */
    private $codePostal;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="garage")
     * @Groups({"garage:get"})
     */
    private $annonces;

    /**
     * @ORM\ManyToOne(targetEntity=Professionnel::class, inversedBy="garages")
     * @Groups({"annonce:get", "garage:get"})
     */
    public $professionnel;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getAdresseLigne1(): ?string
    {
        return $this->adresseLigne1;
    }

    public function setAdresseLigne1(string $adresseLigne1): self
    {
        $this->adresseLigne1 = $adresseLigne1;

        return $this;
    }

    public function getAdresseLigne2(): ?string
    {
        return $this->adresseLigne2;
    }

    public function setAdresseLigne2(?string $adresseLigne2): self
    {
        $this->adresseLigne2 = $adresseLigne2;

        return $this;
    }

    public function getAdresseLigne3(): ?string
    {
        return $this->adresseLigne3;
    }

    public function setAdresseLigne3(?string $adresseLigne3): self
    {
        $this->adresseLigne3 = $adresseLigne3;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setGarage($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getGarage() === $this) {
                $annonce->setGarage(null);
            }
        }

        return $this;
    }

    public function getProfessionnel(): ?Professionnel
    {
        return $this->professionnel;
    }

    public function setProfessionnel(?Professionnel $professionnel): self
    {
        $this->professionnel = $professionnel;

        return $this;
    }
}
